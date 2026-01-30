@extends('reports.pdf.layout')

@section('content')
    <div class="meta">
        <h2 style="margin-bottom: 10px;">Laporan Kerusakan & Kehilangan</h2>
        <p>Periode: 
            {{ request('start_date') ? date('d/m/Y', strtotime(request('start_date'))) : 'Awal' }} 
            s/d 
            {{ request('end_date') ? date('d/m/Y', strtotime(request('end_date'))) : 'Sekarang' }}
        </p>
    </div>

    <!-- Summary -->
    <table style="width: 50%; margin-bottom: 20px;">
        <tr>
            <td style="font-weight: bold;">Total Item Rusak:</td>
            <td>{{ $summary['total_damaged'] }} Item</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Total Item Hilang:</td>
            <td>{{ $summary['total_lost'] }} Item</td>
        </tr>
    </table>

    <!-- Table -->
    <table class="data">
        <thead>
            <tr>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 25%">Barang</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 10%">Qty</th>
                <th style="width: 25%">Keterangan</th>
                <th style="width: 15%">Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mutations as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{ $log->item->name }}<br>
                        <small style="color: #666;">{{ $log->item->code }}</small>
                    </td>
                    <td>
                        @if($log->type == 'damaged')
                            <span class="badge badge-red">Rusak</span>
                        @else
                            <span class="badge badge-gray">Hilang</span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $log->qty }} {{ $log->item->unit }}</td>
                    <td>{{ $log->reason ?? '-' }}</td>
                    <td>{{ $log->creator->name ?? 'System' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
