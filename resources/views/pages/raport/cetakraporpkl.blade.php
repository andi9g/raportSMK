<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $identitas["nisn"]." - ".$identitas["nama"] }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
        }

        table {
            margin: 0;
            padding: 0;
        }

        
        .table-border {
            border-collapse: collapse;
        }

        .judul {
            text-align: center;
        } 
        .table td {
            padding-left: 3px; 
            padding-top: 2px; 
            padding-bottom: 2px; 
        }
        .table-border td {
            padding: 5px; 
            padding-left: 10px; 
            padding-right: 10px; 
        }
        h1, h2, h3, h4, h5, h6 {
            margin: 0;
            padding: 0;
        }
        h4 {
            font-weight: normal;
        }
    </style>
</head>
<body>

    <table style="width:100%" border="0" class="judul" align="center">
        <tr>
            <td><h3><b>RAPOR PKL SMK NEGERI 1 GUNUNG KIJANG</b></h3></td>
        </tr>
        <tr>
            <td><h4>TAHUN PELAJARAN {!! $identitas["tahunajaran"] !!}</h4></td>
        </tr>
    </table>
    <br>

    <table class="table" width="100%" border="0" style="font-size: 12px">
        <tr>
            <td style="width:30%;">Nama Murid</td>
            <td width="5px">:</td>
            <td style="font-weight: bold">{!! $identitas["nama"] !!}</td>
        </tr>
        <tr>
            <td style="width:30%;">NIS / NISN</td>
            <td width="5px">:</td>
            <td style="font-weight: bold">{!! $identitas["nis"]. " / ".$identitas["nisn"] !!}</td>
        </tr>
        <tr>
            <td style="width:30%;">Kelas</td>
            <td width="5px">:</td>
            <td style="font-weight: bold">{!! $identitas["kelas"]." ".$identitas["jurusan"] !!}</td>
        </tr>
        <tr>
            <td style="width:30%;">Program Keahlian</td>
            <td width="5px">:</td>
            <td style="font-weight: bold">{{ ucwords(strtolower($identitas["namaprogram"])) }}</td>
        </tr>
        <tr>
            <td style="width:30%;">Konsentrasi Keahlian</td>
            <td width="5px">:</td>
            <td style="font-weight: bold">{{ ucwords(strtolower($identitas["namakonsentrasi"])) }}</td>
        </tr>
        <tr>
            <td style="width:30%;">Tempat PKL</td>
            <td width="5px">:</td>
            <td style="font-weight: bold">{!! $identitas["tempatpkl"] !!}</td>
        </tr>
        <tr valign="top">
            <td style="width:30%;">Tanggal PKL</td>
            <td width="5px">:</td>
            <td>
                <table width="100%" border="0" style="margin:-2px">
                    <tr style="margin: 0;padding: 0">
                        <td style="margin: 0;padding: 0" width="5px">Mulai</td>
                        <td style="margin: 0;padding: 0" width="5px">:</td>
                        <td style="margin: 0;padding: 0;font-weight: bold">{{ \Carbon\Carbon::parse($pkl->tanggalmulai)->isoFormat(" DD MMMM YYYY") }}</td>
                    </tr>
                    <tr style="margin: 0;padding: 0">
                        <td style="margin: 0;padding: 0" width="5px">Selesai</td>
                        <td style="margin: 0;padding: 0" width="5px">:</td>
                        <td style="margin: 0;padding: 0;font-weight: bold">{{ \Carbon\Carbon::parse($pkl->tanggalselesai)->isoFormat(" DD MMMM YYYY") }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width:30%;">Nama Instruktur</td>
            <td width="5px">:</td>
            <td style="font-weight: bold">{!! $identitas["pembimbingdudi"] !!} </td>
        </tr>
        <tr>
            <td style="width:30%;">Jabatan Pembimbing</td>
            <td width="5px">:</td>
            <td style="font-weight: bold">{!! $identitas["jabatan"] !!} </td>
        </tr>
    </table>




    <br>
    <table class="table-border" width="100%" border="1">
        <tr align="center" style="font-weight: bold;background:rgba(180, 180, 180, 0.534)">
            <td>TUJUAN PEMBELAJARAN</td>
            <td>SKOR</td>
            <td>DESKRIPSI</td>
        </tr>

        @foreach ($nilai as $item)
            <tr>
                <td width="40%">{!! $item["cp"] !!}</td>
                <td align="center">{!! $item["nilai"] !!}</td>
                <td width="55%">{!! $item["deskripsi"] !!}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="3">
                <p style="font-weight: bold;margin:0;padding:0">Catatan:</p>
                <p style="margin: 0;margin-top:3px;margin-bottom:6px">{!! $identitas["catatanpkl"] !!}</p>
            </td>
        </tr>
    </table>


    <br>
    <table class="table-border" border="1" >
        <tr>
            <td colspan="2" align="left" style="font-weight: bold;background:rgba(180, 180, 180, 0.534)"">
                KEHADIRAN
            </td>
        </tr>
        <tr>
            <td width="100px">Sakit</td>
            <td align="center">{!! $identitas["sakit"] !!}</td>
        </tr>
        <tr>
            <td width="100px">Izin</td>
            <td align="center">{!! $identitas["izin"] !!}</td>
        </tr>
        <tr>
            <td width="100px">Alpa</td>
            <td align="center">{!! $identitas["alfa"] !!}</td>
        </tr>
    </table>

    <br>

    <table width="100%">
        <tr>
            <td width="5%"></td>
            <td>
                <table width="100%">
                     <tr>
                        <td width="33%"></td>
                        <td width="33%"></td>
                        <td width="33%">Gunung Kijang, {{ \Carbon\Carbon::parse($pkl->tanggalcetak)->isoFormat(" DD MMMM YYYY") }}</td>
                    </tr>
                    <tr valign="top">
                        <td>
                            <p style="margin:0;padding:0">Wali Kelas</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p style="font-weight: bold;margin:0;padding:0" >
                                @php
                                    $namapisah = explode(",", $walikelaspkl->user->name);
                                @endphp
                                @for ($i = 1; $i <= count($namapisah); $i++)
                                    @if ($i == 1)
                                        @php
                                            $nama = ucwords(strtolower($namapisah[($i -1)]));
                                        @endphp
                                    @else
                                        @php
                                            $nama = $nama.", ".$namapisah[($i -1)];
                                        @endphp
                                    @endif
                                @endfor
                                <u>
                                    {{ $nama }}

                                </u>
                            </p>
                            <p style="font-weight: bold;margin:0;padding:0" >
                                @if (!empty($walikelaspkl->user->identitas->inip))
                                    {{ $walikelaspkl->user->identitas->inip.". ".$walikelaspkl->user->identitas->nip }}
                                @endif
                            </p>
                        </td>

                        <td>
                            <p style="margin:0;padding:0">Guru Pembimbing</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p style="font-weight: bold;margin:0;padding:0" >
                                @php
                                    $namapisah = explode(",", $pesertapkl->user->name);
                                @endphp
                                @for ($i = 1; $i <= count($namapisah); $i++)
                                    @if ($i == 1)
                                        @php
                                            $nama = ucwords(strtolower($namapisah[($i -1)]));
                                        @endphp
                                    @else
                                        @php
                                            $nama = $nama.", ".$namapisah[($i -1)];
                                        @endphp
                                    @endif
                                @endfor
                                <u>
                                    {{ $nama }}

                                </u>
                            </p>
                            <p style="font-weight: bold;margin:0;padding:0" >
                                @if (!empty($pesertapkl->user->identitas->inip))
                                    {{ $pesertapkl->user->identitas->inip.". ".$pesertapkl->user->identitas->nip }}
                                @endif
                            </p>
                        </td>
                        <td>
                            <p style="margin:0;padding:0">Pembimbing Dunia Kerja</p>
                            <p style="margin:0;padding:0">{{ $pesertapkl->jabatan }}</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p style="font-weight: bold;margin:0;padding:0" >
                                @php
                                    $namapisah = explode(",", $pesertapkl->pembimbingdudi);
                                @endphp
                                @for ($i = 1; $i <= count($namapisah); $i++)
                                    @if ($i == 1)
                                        @php
                                            $nama = ucwords(strtolower($namapisah[($i -1)]));
                                        @endphp
                                    @else
                                        @php
                                            $nama = $nama.", ".$namapisah[($i -1)];
                                        @endphp
                                    @endif
                                @endfor
                                <u>
                                    {{ $nama }}

                                </u>
                            </p>
                            
                        </td>
                    </tr>

                </table>

            </td>
            <td width="5%"></td>
        </tr>
       

    </table>

    {{-- TTD bagian bawah --}}
    <br>
    <br>
    <br>
    <table width="100%">
        <tr>
            <td width="15%"></td>
            <td>
                <table width="100%">
                    <tr valign="top">
                        <td width="50%">
                            <p style="margin:0;padding:0">Mengetahui</p>
                            <p style="margin:0;padding:0">Kepala Sekolah SMK Negeri 1 Gunung Kijang</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p style="font-weight: bold;margin:0;padding:0" >
                                @php
                                    $namapisah = explode(",", $kepalasekolahpkl->user->name);
                                @endphp
                                @for ($i = 1; $i <= count($namapisah); $i++)
                                    @if ($i == 1)
                                        @php
                                            $nama = ucwords(strtolower($namapisah[($i -1)]));
                                        @endphp
                                    @else
                                        @php
                                            $nama = $nama.", ".$namapisah[($i -1)];
                                        @endphp
                                    @endif
                                @endfor
                                <u>
                                    {{ $nama }}

                                </u>
                            </p>
                            <p style="font-weight: bold;margin:0;padding:0" >
                                @if (!empty($kepalasekolahpkl->user->identitas->inip))
                                    {{ $kepalasekolahpkl->user->identitas->inip.". ".$kepalasekolahpkl->user->identitas->nip }}
                                @endif
                            </p>
                        </td>

                        <td>
                            <p style="margin:0;padding:0">Ketua Program Keahlian</p>
                            <p style="margin:0;padding:0">{{ ucwords(strtolower($identitas["namajurusan"])) }}</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p style="font-weight: bold;margin:0;padding:0" >
                                @php
                                    $namapisah = explode(",", $kajurpkl->user->name);
                                @endphp
                                @for ($i = 1; $i <= count($namapisah); $i++)
                                    @if ($i == 1)
                                        @php
                                            $nama = ucwords(strtolower($namapisah[($i -1)]));
                                        @endphp
                                    @else
                                        @php
                                            $nama = $nama.", ".$namapisah[($i -1)];
                                        @endphp
                                    @endif
                                @endfor
                                <u>
                                    {{ $nama }}

                                </u>
                            </p>
                            <p style="font-weight: bold;margin:0;padding:0" >
                                @if (!empty($kajurpkl->user->identitas->inip))
                                    {{ $kajurpkl->user->identitas->inip.". ".$kajurpkl->user->identitas->nip }}
                                @endif
                            </p>
                        </td>
                        
                    </tr>

                </table>

            </td>
            <td width="5%"></td>
        </tr>
       

    </table>


    
</body>
</html>