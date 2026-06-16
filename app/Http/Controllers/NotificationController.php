<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\NotificationMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        return view('notifications.index', [
            'lowStockItems' => Item::query()->whereColumn('current_stock', '<=', 'minimum_stock')->orderBy('name')->get(),
            'messages' => NotificationMessage::query()->latest()->limit(25)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'channel' => ['required', 'in:email,whatsapp,internal'],
            'recipient' => ['required', 'string', 'max:150'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        NotificationMessage::create($data + ['status' => 'queued']);

        return back()->with('status', 'Pesan masuk ke antrean komunikasi.');
    }
}
