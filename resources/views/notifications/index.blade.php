@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h1>Notifikasi & Komunikasi</h1>
        <p class="page-copy">Kelola pengiriman pesan sistem dan pantau ambang batas persediaan.</p>
    </div>
</div>

<div class="grid notification-board">
    <section class="card card-light span-5">
        <div class="section-head">
            <h2>▷ Kirim Pesan</h2>
        </div>

        <div class="card-body">
            <form method="post" action="{{ route('notifications.store') }}">
                @csrf
                <div class="field-group">
                    <label>Channel</label>
                    <select name="channel" required>
                        <option value="internal">Internal</option>
                        <option value="email">Email Notification</option>
                        <option value="whatsapp">WhatsApp</option>
                    </select>
                </div>
                <div class="field-group">
                    <label>Penerima</label>
                    <input name="recipient" placeholder="email@vendor.com atau Nama Gudang" required>
                </div>
                <div class="field-group">
                    <label>Subjek</label>
                    <input name="subject" placeholder="Masukkan judul pesan..." required>
                </div>
                <div class="field-group">
                    <label>Pesan</label>
                    <textarea name="message" placeholder="Tulis rincian pesan di sini..." required></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit">▹ Antrekan Pesan</button>
                </div>
            </form>
        </div>
    </section>

    <section class="card span-7">
        <div class="section-head">
            <h2>△ Stok Perlu Notifikasi</h2>
            <span class="pill warning">{{ $lowStockItems->count() }} Kritis</span>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Barang</th>
                        <th>Stok</th>
                        <th>Min.</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lowStockItems as $item)
                        <tr>
                            <td>{{ $item->sku }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="danger">{{ $item->current_stock }}</td>
                            <td>{{ $item->minimum_stock }}</td>
                            <td><a class="table-action" href="{{ route('inventory.index') }}">Order</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="card span-12">
        <div class="section-head">
            <h2>↻ Riwayat Komunikasi</h2>
            <div class="toolbar-actions">
                <button type="button" class="button ghost">Export CSV</button>
                <button type="button" class="button ghost">Filter</button>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Channel</th>
                        <th>Penerima</th>
                        <th>Subjek</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                        <tr>
                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ ucfirst($message->channel) }}</td>
                            <td>{{ $message->recipient }}</td>
                            <td>{{ $message->subject }}</td>
                            <td><span class="pill success">{{ $message->status }}</span></td>
                            <td><span class="muted">-</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
