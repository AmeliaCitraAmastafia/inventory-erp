@extends('layouts.app')

@section('content')
<section>
    <div class="no-print" style="margin-bottom: 14px;">
        <button onclick="window.print()">Print</button>
    </div>
    <h1>Laporan Stok Barang</h1>
    <p class="muted">Tanggal cetak: {{ now()->format('d/m/Y H:i') }}</p>
    <table>
        <thead><tr><th>SKU</th><th>Nama</th><th>Kategori</th><th>Stok</th><th>Minimum</th><th>Status</th></tr></thead>
        <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->sku }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category ?: '-' }}</td>
                <td>{{ $item->current_stock }} {{ $item->unit }}</td>
                <td>{{ $item->minimum_stock }} {{ $item->unit }}</td>
                <td>{{ $item->current_stock <= $item->minimum_stock ? 'Perlu restock' : 'Aman' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</section>
@endsection
