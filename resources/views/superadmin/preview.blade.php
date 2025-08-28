<div style="max-width: 800px; margin:auto; background: #fff; padding: 40px; border: 1px solid #000;">

    {{-- KOP SURAY --}}
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

    {{-- JUDUL SURAT --}}
    <div class="text-center mb-4">
        <h5 style="font-weight: bold"><u>SURAT TUGAS</u></h5>
        <p>NOMOR   : {{ $spt->nomor_surat }}</p>
    </div>

    {{-- DASAR --}}
    <table class="mb-3" style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="width:100px; vertical-align: top;">DASAR</td>
            <td style="width:10px; vertical-align: top;">:</td>
            <td>
                <ol style="margin:0; padding-left:15px; text-align: justify;">
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
    <table class="mb-3" style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="width:100px; vertical-align: top;">KEPADA</td>
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
    </table>

    {{-- UNTUK --}}
    <table class="mb-3" style="width:100%; border-collapse: collapse;">
        <tr>
            <td style="width:100px; vertical-align: top;">UNTUK</td>
            <td style="width:10px; vertical-align: top;">:</td>
            <td style="text-align: justify;">
                {!! nl2br(e($spt->untuk)) !!}
            </td>
        </tr>
    </table>

{{-- tanggal & tempat --}}
    <div class="mt-5" style="text-align: right;">
        <table style="margin-left: auto; margin-right: 60px; text-align: left;">
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
                    @if($spt->penandatangan)
                        {{ $spt->penandatangan->jabatan }}
                    @else
                        [Silakan pilih penandatangan]
                    @endif
                </td>
            </tr>

            <tr><td colspan="2" style="padding: 40px 0;"></td></tr>     {{-- spasi ttd--}}

            <tr>
                <td colspan="2">
                    @if($spt->penandatangan)
                        {{ $spt->penandatangan->nama }}
                    @else
                        ______________________
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    @if($spt->penandatangan)
                        {{ $spt->penandatangan->pangkat_gol }}
                    @else
                        Pangkat/Gol: __________
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    @if($spt->penandatangan)
                        NIP. {{ $spt->penandatangan->nip }}
                    @else
                        NIP. __________
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<div style="text-align: center; margin-top: 20px;">
    <a href="{{ route('superadmin.spt.exportWord', $spt->id) }}" class="btn btn-primary btn-sm">Export Word</a>
</div>
