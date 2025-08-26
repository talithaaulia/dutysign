<div style="max-width: 800px; margin:auto; background: #fff; padding: 40px; border: 1px solid #000;">

    {{-- Kop Surat --}}
    <table>
        <tr>
            <td style="width:80px; text-align:center; vertical-align:top;">
                <img src="{{ asset('images/logo-dinsos.png') }}" alt="Logo" style="width:120px; height:auto;">
            </td>

            <td style="text-align:center;">
                <div class="text-center mb-4">
                    <h5 class="mb-0">PEMERINTAH PROVINSI JAWA TIMUR</h5>
                    <h5 class="mb-0" style="font-weight: bold;">DINAS SOSIAL</h5>
                    <p class="mb-0">Jalan Gayung Kebonsari Nomor 56 B, Gayungan, Surabaya, Jawa Timur 60235</p>
                    <p class="mb-0">Telepon (031) 8290734 / 8296515, Laman http://dinsos.jatimprov.go.id</p>
                    <p class="mb-0">Pos-el dinsosjatim56b@gmail.com</p>
                </div>
            </td>
        </tr>
    </table>

    {{-- Judul Surat --}}
    <div class="text-center mb-4">
        <h5 style="font-weight: bold"><u>SURAT TUGAS</u></h5>
        <p>NOMOR   : {{ $spt->nomor_surat }}</p>
    </div>

{{-- DASAR --}}
{{-- <table class="mb-3" style="width:100%; border-collapse: collapse;">
    <tr>
        <td style="width:120px; vertical-align: top;">DASAR</td>
        <td style="width:10px; vertical-align: top;">:</td>
        <td>
            <ol style="margin:0; padding-left:15px;">
                @foreach(explode("\n", $spt->dasar) as $d)
                    <li>{{ $d }}</li>
                @endforeach
            </ol>
        </td>
    </tr>
</table> --}}

<table class="mb-3" style="width:100%; border-collapse: collapse;">
    <tr>
        <td style="width:120px; vertical-align: top;"><strong>DASAR :</strong></td>
        <td>
            <ol style="word-break: break-word; white-space: normal; max-width: 500px; margin:0; padding-left:15px;">
                @foreach(explode("\n", $spt->dasar) as $d)
                    <li>{{ $d }}</li>
                @endforeach
            </ol>
        </td>
    </tr>
</table>

{{-- MEMERINTAHKAN --}}
<div class="text-center mb-2">
    <strong>MEMERINTAHKAN</strong>
</div>

{{-- KEPADA --}}
{{-- <table class="mb-3" style="width:100%; border-collapse: collapse;">
    <tr>
        <td style="width:120px; vertical-align: top;">KEPADA</td>
        <td style="width:10px; vertical-align: top;">:</td>
        <td>
            <ol style="margin:0; padding-left:15px;">
                @foreach($spt->pegawais as $p)
                    <li style="margin-bottom:10px;">
                        <table style="width:100%; border-collapse: collapse; margin-left:5px;">
                            <tr>
                                <td style="width:90px;">Nama</td>
                                <td style="width:10px;">:</td>
                                <td>{{ $p->nama }}</td>
                            </tr>
                            <tr>
                                <td>
                                    @if($p->nip)
                                        NIP
                                    @elseif($p->niptt_pk)
                                        NIPTT-PK
                                    @else
                                        NIP
                                    @endif
                                </td>
                                <td>:</td>
                                <td>{{ $p->nip ?? $p->niptt_pk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Jabatan</td>
                                <td>:</td>
                                <td>{{ $p->jabatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pangkat/Gol</td>
                                <td>:</td>
                                <td>{{ $p->pangkat_gol ?? '-' }}</td>
                            </tr>
                        </table>
                    </li>
                @endforeach
            </ol>
        </td>
    </tr>
</table> --}}

{{-- UNTUK --}}
{{-- <table class="mb-3" style="width:100%; border-collapse: collapse;">
    <tr>
        <td style="width:120px; vertical-align: top;">UNTUK</td>
        <td style="width:10px; vertical-align: top;">:</td>
        <td style="text-align: justify;">
            {!! nl2br(e($spt->untuk)) !!}
        </td>
    </tr>
</table> --}}


    {{-- Tanggal & Tempat --}}
    {{-- <div class="text-end mt-5">
        <table style="margin-left: auto; text-align: left;">
            <tr>
                <td style="padding-right: 10px;">Ditetapkan di</td>
                <td>: {{ $spt->ditetapkan_di }}</td>
            </tr>
            <tr>
                <td>Pada tanggal</td>
                <td>: {{ \Carbon\Carbon::parse($spt->tanggal)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td colspan="2">
                    a.n. Kepala Dinas Sosial <br>
                    Provinsi Jawa Timur <br>
                    {{ $spt->signer_data['jabatan'] ?? '[Jabatan]' }}
                </td>
            </tr> --}}

            {{-- spasi ttd --}}
            {{-- <tr><td colspan="2" style="padding: 50px 0;"></td></tr>

            <tr>
                <td colspan="2">
                    {{ $spt->signer_data['nama'] ?? '________________' }}
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    {{ $spt->signer_data['pangkat'] ?? '[Pangkat Golongan]' }}
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    NIP {{ $spt->signer_data['nip'] ??  '________________' }}
                </td>
            </tr>
        </table>
    </div>
</div> --}}


{{-- KEPADA --}}
<table class="mb-3" style="width:100%; border-collapse: collapse;"">
    <tr>
        <td style="width:120px; vertical-align: top;"><strong>KEPADA :</strong></td>
        <td>
            <ol style="word-break: break-word; white-space: normal; max-width: 500px; margin:0; padding-left:15px;">
                @foreach($spt->pegawais as $p)
                    <li>{{ $p->nama }} - {{ $p->jabatan ?? '-' }}</li>
                @endforeach
            </ol>
        </td>
    </tr>
</table>

{{-- UNTUK --}}
<table class="mb-3" style="width:100%; border-collapse: collapse;">
    <tr>
        <td style="width:120px; vertical-align: top;"><strong>UNTUK :</strong></td>
        <td style="word-break: break-word; white-space: normal; max-width: 500px;">
            {{ $spt->untuk }}
        </td>
    </tr>
</table>


    {{-- Tanggal & Tempat --}}
<div class="text-end mt-5">
    <p>
        Ditetapkan di: {{ $spt->ditetapkan_di }} <br>
        Pada tanggal: {{ \Carbon\Carbon::parse($spt->tanggal)->translatedFormat('d F Y') }} <br>
        a.n. Kepala Dinas Sosial <br>
        Provinsi Jawa Timur <br>
        @if($spt->penandatangan)
            {{ $spt->penandatangan->jabatan }}
        @else
            [Silakan pilih penandatangan]
        @endif
    </p>

    <br><br><br> {{-- Jarak untuk tanda tangan --}}

    @if($spt->penandatangan)
        <strong><u>{{ $spt->penandatangan->nama }}</u></strong><br>
        {{ $spt->penandatangan->pangkat_gol }}<br>
        NIP. {{ $spt->penandatangan->nip }}
    @else
        ______________________ <br>
        Pangkat/Gol: __________ <br>
        NIP. __________
    @endif
</div>

<div class="mt-5">
    <a href="{{ route('superadmin.spt.exportWord', $spt->id) }}" class="btn btn-primary btn-sm">Export Word</a>
</div>
