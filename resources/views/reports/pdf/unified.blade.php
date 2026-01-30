@extends('reports.pdf.layout')

@section('content')
    <div class="meta" style="text-align: center; margin-bottom: 30px;">
        <h2 style="margin: 0; padding: 0;">Laporan Lengkap</h2>
        <p style="margin: 5px 0 0; color: #666;">
            Periode: 
            @if($startDate && $endDate)
                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            @elseif($startDate)
                Sejak {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
            @else
                Semua Data
            @endif
        </p>
    </div>

    {{-- SECTION 1: KERUSAKAN & KEHILANGAN --}}
    <h3 style="margin-top: 30px; border-bottom: 1px solid #ddd; padding-bottom: 5px;">1. Kerusakan & Kehilangan</h3>
    
    <div style="margin-bottom: 15px;">
        <strong>Total Rusak:</strong> {{ $lossSummary['total_damaged'] }} items &nbsp;|&nbsp;
        <strong>Total Hilang:</strong> {{ $lossSummary['total_lost'] }} items
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 20%">Tanggal</th>
                <th style="width: 25%">Barang</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 10%">Jumlah</th>
                <th style="width: 20%">Alasan</th>
                <th style="width: 15%">Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lossMutations as $mutation)
            <tr>
                <td>{{ $mutation->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <strong>{{ $mutation->item->name }}</strong><br>
                    <small style="color: #666;">{{ $mutation->item->code }}</small>
                </td>
                <td style="text-align: center;">
                    @if($mutation->type === 'damaged')
                        <span class="badge badge-red">Rusak</span>
                    @else
                        <span class="badge badge-gray">Hilang</span>
                    @endif
                </td>
                <td style="text-align: center;">{{ $mutation->qty }}</td>
                <td>{{ $mutation->reason ?? '-' }}</td>
                <td>{{ $mutation->creator->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 15px; color: #666;">Tidak ada data kerusakan atau kehilangan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="page-break-after: always;"></div>

    {{-- SECTION 2: MUTASI STOK --}}
    <h3 style="border-bottom: 1px solid #ddd; padding-bottom: 5px;">2. Mutasi Stok</h3>
    <table class="data">
        <thead>
            <tr>
                <th style="width: 20%">Tanggal</th>
                <th style="width: 25%">Barang</th>
                <th style="width: 10%">Tipe</th>
                <th style="width: 10%">Qty</th>
                <th style="width: 20%">Keterangan</th>
                <th style="width: 15%">Dicatat Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stockMutations as $mutation)
            <tr>
                <td>{{ $mutation->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <strong>{{ $mutation->item->name }}</strong><br>
                    <small style="color: #666;">{{ $mutation->item->code }}</small>
                </td>
                <td style="text-align: center;">
                    <span class="badge badge-{{ $mutation->type_badge }}">
                        {{ ucfirst($mutation->type) }}
                    </span>
                </td>
                <td style="text-align: center;">
                    <span style="color: {{ in_array($mutation->type, ['in']) ? 'green' : 'red' }}">
                        {{ in_array($mutation->type, ['in']) ? '+' : '-' }}{{ $mutation->qty }}
                    </span>
                </td>
                <td>{{ $mutation->reason ?? '-' }}</td>
                <td>{{ $mutation->creator->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 15px; color: #666;">Tidak ada data mutasi stok.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="page-break-after: always;"></div>

    {{-- SECTION 3: PENGGUNAAN ALAT --}}
    <h3 style="border-bottom: 1px solid #ddd; padding-bottom: 5px;">3. Penggunaan Alat (Tools)</h3>
    <table class="data">
        <thead>
            <tr>
                <th style="width: 5%">#</th>
                <th style="width: 45%">Nama Alat</th>
                <th style="width: 25%">Kode</th>
                <th style="width: 10%">Stok Saat Ini</th>
                <th style="width: 15%">Total Penggunaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tools as $index => $tool)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $tool->name }}</td>
                <td>{{ $tool->code }}</td>
                <td style="text-align: center;">{{ $tool->stock }}</td>
                <td style="text-align: center; font-weight: bold;">{{ $tool->usage_count }} kali</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 15px; color: #666;">Tidak ada data penggunaan alat.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection
