@extends('reports.pdf.layout')

@section('content')
    <div class="meta">
        <h2 style="margin-bottom: 10px;">Laporan Penggunaan Alat (Tool Utilization)</h2>
        <p>Periode: 
            {{ request('start_date') ? date('d/m/Y', strtotime(request('start_date'))) : 'Awal' }} 
            s/d 
            {{ request('end_date') ? date('d/m/Y', strtotime(request('end_date'))) : 'Sekarang' }}
        </p>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 35%">Nama Alat</th>
                <th style="width: 20%">Kode Aset</th>
                <th style="width: 20%">Stok Saat Ini</th>
                <th style="width: 20%">Frekuensi Dipinjam</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tools as $index => $tool)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $tool->name }}</td>
                    <td>{{ $tool->code }}</td>
                    <td style="text-align: center;">{{ $tool->stock }} {{ $tool->unit }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $tool->usage_count }}x</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data alat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
