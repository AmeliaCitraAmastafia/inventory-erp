@extends('layouts.app')

@section('content')
<h1>Cetak Laporan</h1>

<div class="grid">
    <section class="span-4">
        <h2>Ringkasan</h2>
        <p>Total barang: <strong>{{ $items->count() }}</strong></p>
        <p>Stok perlu perhatian: <strong>{{ $lowStockCount }}</strong></p>
        <a class="button" href="{{ route('reports.stock.print') }}">Cetak Laporan Stok</a>
    </section>

    <section class="span-8">
        <h2>Mutasi Terbaru</h2>
        <table>
            <thead><tr><th>Tanggal</th><th>Barang</th><th>Tipe</th><th>Jumlah</th><th>Referensi</th></tr></thead>
            <tbody>
            @foreach ($recentMovements as $movement)
                <tr>
                    <td>{{ $movement->movement_date->format('d/m/Y') }}</td>
                    <td>{{ $movement->item?->name }}</td>
                    <td><span class="pill">{{ $movement->type }}</span></td>
                    <td>{{ $movement->quantity }}</td>
                    <td>{{ $movement->reference ?: '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
</div>
@endsection
