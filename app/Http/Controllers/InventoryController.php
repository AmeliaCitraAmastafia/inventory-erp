<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use GuzzleHttp\Exception\ClientException;
use Google\Client as GoogleClient;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        return view('inventory.index', [
            'items' => Item::query()->latest()->get(),
            'movements' => StockMovement::query()->with('item')->latest()->limit(15)->get(),
        ]);
    }

    public function storeItem(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'sku' => ['required', 'string', 'max:50', 'unique:items,sku'],
            'name' => ['required', 'string', 'max:150'],
            'category' => ['nullable', 'string', 'max:100'],
            'unit' => ['required', 'string', 'max:30'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'current_stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_url'] = $this->uploadImageToDrive($request);
        }

        unset($data['image']);

        Item::create($data);

        return back()->with('status', 'Barang berhasil ditambahkan.');
    }

    public function updateItem(Request $request, Item $item): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'category' => ['nullable', 'string', 'max:100'],
            'unit' => ['required', 'string', 'max:30'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
            'current_stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_url'] = $this->uploadImageToDrive($request);
        }

        unset($data['image']);

        $item->update($data);

        return back()->with('status', 'Barang berhasil diperbarui.');
    }

    public function destroyItem(Item $item): RedirectResponse
    {
        $item->delete();

        return back()->with('status', 'Barang berhasil dihapus.');
    }

    private function uploadImageToDrive(Request $request): string
    {
        $folderId = config('services.google_drive.folder_id');
        $user = $request->user();

        if (! $folderId) {
            abort(422, 'Konfigurasi Google Drive belum lengkap. Isi GOOGLE_DRIVE_FOLDER_ID di .env.');
        }

        if (! $user->google_token) {
            abort(422, 'Akun Google belum memiliki izin Drive. Logout lalu login Google lagi untuk memberi izin upload ke Drive.');
        }

        $image = $request->file('image');
        $client = new GoogleClient();
        $client->useApplicationDefaultCredentials(false);
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->addScope(Drive::DRIVE_FILE);
        $client->setAccessToken([
            'access_token' => $user->google_token,
            'refresh_token' => $user->google_refresh_token,
        ]);

        if ($client->isAccessTokenExpired()) {
            if (! $user->google_refresh_token) {
                abort(422, 'Izin Google Drive sudah kedaluwarsa. Logout lalu login Google lagi untuk memberi izin upload ke Drive.');
            }

            try {
                $token = $client->fetchAccessTokenWithRefreshToken($user->google_refresh_token);
            } catch (ClientException $e) {
                if (str_contains($e->getMessage(), 'invalid_client')) {
                    throw ValidationException::withMessages([
                        'image' => 'Upload gagal karena Google Client Secret tidak valid. Salin ulang GOOGLE_CLIENT_SECRET dari Google Cloud Console ke file .env.',
                    ]);
                }

                throw $e;
            }

            if (isset($token['error'])) {
                abort(422, 'Gagal memperbarui izin Google Drive. Logout lalu login Google lagi.');
            }

            $user->forceFill([
                'google_token' => $token['access_token'],
            ])->save();
        }

        $drive = new Drive($client);

        try {
            $file = $drive->files->create(new DriveFile([
                'name' => uniqid('item-', true).'.'.$image->getClientOriginalExtension(),
                'parents' => [$folderId],
            ]), [
                'data' => file_get_contents($image->getRealPath()),
                'mimeType' => $image->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id',
                'supportsAllDrives' => true,
            ]);

            $drive->permissions->create($file->id, new Permission([
                'type' => 'anyone',
                'role' => 'reader',
            ]), ['supportsAllDrives' => true]);
        } catch (\Google\Service\Exception $e) {
            if ($e->getCode() === 403 && str_contains($e->getMessage(), 'Service Accounts do not have storage quota')) {
                abort(422, 'Gagal upload Google Drive: service account tidak punya kuota penyimpanan. Gunakan shared drive atau OAuth login Google biasa.');
            }

            throw $e;
        }

        return "https://drive.google.com/thumbnail?id={$file->id}&sz=w240";
    }

    public function storeMovement(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'type' => ['required', 'in:masuk,keluar'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reference' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
            'movement_date' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($data): void {
            $item = Item::query()->lockForUpdate()->findOrFail($data['item_id']);
            $delta = $data['type'] === 'masuk' ? $data['quantity'] : -$data['quantity'];

            $item->update([
                'current_stock' => max(0, $item->current_stock + $delta),
            ]);

            StockMovement::create($data);
        });

        return back()->with('status', 'Mutasi stok berhasil dicatat.');
    }
}
