@extends('reports.pdf.layout')

@section('content')
    <div class="meta">
        <h2 style="margin-bottom: 10px;">Laporan Pergerakan Stok (Stock Movement)</h2>
        <p>Periode: 
            {{ request('start_date') ? date('d/m/Y', strtotime(request('start_date'))) : 'Awal' }} 
            s/d 
            {{ request('end_date') ? date('d/m/Y', strtotime(request('end_date'))) : 'Sekarang' }}
        </p>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 25%">Barang</th>
                <th style="width: 10%">Jenis</th>
                <th style="width: 10%">Qty</th>
                <th style="width: 10%">Stok Akhir</th>
                <th style="width: 20%">Keterangan</th>
                <th style="width: 10%">Oleh</th>
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
                        <span class="badge 
                            {{ $log->type == 'in' ? 'badge-green' : 
                              ($log->type == 'out' ? 'badge-blue' : 
                              ($log->type == 'damaged' ? 'badge-red' : 'badge-gray')) }}">
                            {{ strtoupper($log->type) }}
                        </span>
                    </td>
                    <td style="text-align: center;">{{ $log->qty }}</td>
                    <td style="text-align: center;">{{ $log->stock_after }}</td>
                    <td>{{ $log->reason ?? '-' }}</td>
                    <td>{{ $log->creator->name ?? 'System' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data mutasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
