<div style="font-family: Arial, sans-serif; font-size:14px; max-width:800px; margin:auto;">
    <h5 class="text-center"><b>LAPORAN PERJALANAN DINAS</b></h5>

    @php
        $items = [
            'I.'  => ['DASAR', $report->spt->nomor_surat],
            'II.' => ['MAKSUD TUJUAN', $report->maksud_tujuan],
            'III.' => ['WAKTU PELAKSANAAN', $report->waktu_pelaksanaan],
            'IV.' => ['NAMA PETUGAS', $report->spt->pegawais->pluck('nama')->implode(', ')],
            'V.' => ['DAERAH TUJUAN/INSTANSI YANG DIKUNJUNGI', $report->daerah_tujuan],
            'VI.' => ['HADIR DALAM PERTEMUAN', $report->hadir],
            'VII.' => ['PETUNJUK/ARAHAN YANG DIBERIKAN', $report->petunjuk],
            'VIII.' => ['MASALAH DAN TEMUAN', $report->masalah],
            'IX.' => ['SARAN DAN TINDAKAN', $report->saran],
            'X.' => ['LAIN-LAIN', $report->lain_lain],
        ];
    @endphp

    @foreach($items as $no => [$judul, $isi])
        <div style="display:flex; margin-bottom:6px;">
            <div style="width:40px;">{{ $no }}</div>
            <div style="width:250px;">{{ $judul }}</div>
            <div style="width:10px;">:</div>
            <div style="flex:1; word-break: break-word;">{{ $isi ?? '-' }}</div>
        </div>
    @endforeach

    <br><br>
    <div style="text-align:right;">
        <p>Surabaya, {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d F Y') }}</p>
        <p>Pelapor,</p>
        <br><br>
        <p><b>{{ $report->spt->pegawais->first()->nama ?? '-' }}</b></p>
    </div>
</div>
