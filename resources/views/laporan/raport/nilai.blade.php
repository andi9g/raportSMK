<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NILAI RAPORT</title>
    <style>
        @page { margin: 20px 50px; }
        h2 {
            margin:0;
            padding:0;
            font-size: 14pt;
        }

        h3 {


            left:25%;
            width: 50%;

        }
        div {
            margin: 2px 8px;
        }

        .nama {
            margin:auto 20%;
            padding:10px 5px;
            border: 1px solid grey;
            font-size: 16pt;
            text-align: center;
        }

        p {
            margin: 10px auto;
        }

        .judul {
            margin:auto 20%;
            font-size: 16pt;
            text-align: center;
            line-height: 70px;
        }
        .identitas {
            font-size: 12pt;
        }
        p {
            line-height: 5px;
        }

        .fasphoto {
            float: right;
            border:1px solid grey;
            width: 113px;
            height: 151px;
            text-align: center;
            justify-content: center;
        }
        .fontku {
            font-size: 9.5pt;
        }
        .fontku2 {
            font-size: 9pt;
            line-height: 20px;
        }
        .tableku {
            border-collapse: collapse;
        }
        .tableku th {
            padding: auto 5px;
        }
        .tableku td {
            padding: auto 5px;
        }
        .myfont {
            line-height: 13px;
        }
        .mytext {
            margin-bottom: 3px;
            /* text-align: center; */
            font-size: 10pt;
            line-height: 15px;
            font-weight: bold;

        }
        .page:nth-child(3) {
            margin-top: 30mm; /* Margin atas untuk halaman kedua */
        }

        .ukuran-judul {
            padding: 10px auto;
        }
        .ukuran-judul2 {
            padding: 7px auto;
        }

        body {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }


    </style>
</head>
<body>
    @if ($raport->namaraport == "raport uts")
    <div class="myfont">
        <table width="100%">
            <tr>
                <td align="center" width="100%">
                    <div class="mytext">
                        LAPORAN ASESMEN TENGAH SEMESTER {{ strtoupper($raport->semester) }} <br>
                        TP.{{ $raport->tahun }}/{{ $raport->tahun + 1 }} <br>
                        SMKN 1 GUNUNG KIJANG
                    </div>
                    </td>
                </tr>

            </table>
    </div>

    <br>
    @endif
    <table width="100%" class="fontku">
        <tr>
            <td width="50%" valign="top">
                <table width="100%" class="myfont">
                    <tr>
                        <td valign="top" nowrap>Nama Peserta Didik</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">{{ strtoupper($siswa->nama) }}</td>
                    </tr>
                    <tr>
                        <td valign="top" nowrap>Nomor Induk/NISN</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">{{ empty($siswa->nis)?"":$siswa->nis." / " }}{{ ucwords(strtolower($siswa->nisn)) }}</td>
                    </tr>
                    <tr>
                        <td valign="top" nowrap>Sekolah</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">
                            {{ $sekolah->namasekolah }}
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" nowrap>Alamat</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">
                            {{ $sekolah->alamatsekolah }}
                        </td>
                    </tr>
                </table>
            </td>
            <td width="50%" valign="top">
                <table width="100%" class="myfont">
                    <tr>
                        <td valign="top" nowrap>Kelas</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">{{ $detail->kelas->namakelas." ".$siswa->jurusan->jurusan }}</td>
                    </tr>
                    <tr>
                        <td valign="top" nowrap>Fase</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">{{ strtoupper($detail->fase) }}</td>
                    </tr>

                    <tr>
                        <td valign="top" nowrap>Semester</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">
                            {{ ucwords($detail->semester) }}
                        </td>
                    </tr>

                    <tr>
                        <td valign="top" nowrap>Tahun Pelajaran</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">
                            {{ $detail->tahun."/".($detail->tahun+1) }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="fontku page" >
        <b>
            A. Nilai Akademik
        </b>

        <table width="100%" class="tableku" border="1">
            <thead>
                <tr>
                    <th width="2px" style="page-break-inside: avoid;">No</th>
                    <th style="page-break-inside: avoid;width: 200px">Mata pelajaran</th>
                    <th style="page-break-inside: avoid;">Nilai Akhir</th>
                    <th style="page-break-inside: avoid;">Capaian Kompetensi</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                <td colspan="4" class="ukuran-judul">A. Kelompok Mata Pelajaran Umum</td>
            </tr>

            @foreach ($mapel as $item)
                @php
                    if ((!empty($item["capaian"])) && (empty($item["catatan"]))) {
                        $ket = "capaian";
                        $nilai = 1;
                    }elseif((empty($item["capaian"])) && (!empty($item["catatan"]))) {
                        $ket = "catatan";
                        $nilai = 1;
                    }else {
                        $ket = "keduanya";
                        $nilai = 2;
                    }

                    if($item["agama"]==true && $item['ketAgama'] != "Islam") {
                        $nilai = 1;
                        // dd($item["ketAgama"].'error');
                    }
                @endphp

                @if ($item["ket"]=="umum")
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $item["namamapel"] }}</td>
                    <td align="center">{{ $item["nilai"] }}</td>
                    <td class="fontku2" style="padding: 0;page-break-inside: avoid;">
                        <div>
                            @if ($item["agama"]==true && $item['ketAgama'] != "Islam")
                            {{ empty($item["catatanAgama"])?'-':$item["catatanAgama"] }}
                            @else
                            @if ($ket=="capaian")
                                {{ $item["capaian"] }}
                            @elseif($ket=="catatan")
                                {{ $item["catatan"] }}
                            @elseif($ket=="keduanya")
                                {{ $item["capaian"] }}
                            @endif

                            @endif
                        </div>

                        @if (!empty($item["capaian"]) && !empty($item["catatan"]) )
                        <hr style="border:0.5px solid grey;margin: 0;padding: 0;margin-top:5px">

                        @endif

                        <div>
                            @if ($item["agama"]==true && $item['ketAgama'] == "Islam")


                            @if ($ket=="keduanya")
                                {{ $item["catatan"] }}
                            @endif
                            @elseif($item["agama"]==false)
                            @if ($ket=="keduanya")
                                {{ $item["catatan"] }}
                            @endif
                            @endif
                        </div>

                    </td>



                </tr>



                @endif

            @endforeach


            <tr>
                <td colspan="4" class="ukuran-judul">B. Kelompok Mata Pelajaran Kejuruan</td>
            </tr>
            @foreach ($mapel as $item)
                @php
                    if ((!empty($item["capaian"])) && (empty($item["catatan"]))) {
                        $ket = "capaian";
                        $nilai = 1;
                    }elseif((empty($item["capaian"])) && (!empty($item["catatan"]))) {
                        $ket = "catatan";
                        $nilai = 1;
                    }else {
                        $ket = "keduanya";
                        $nilai = 2;
                    }

                    if($item["agama"]==true && $item['ketAgama'] != "Islam") {
                        $nilai = 1;
                        // dd($item["ketAgama"].'error');
                    }
                @endphp

                @if ($item["ket"]=="kejuruan" || $item["ket"]=="pilihan")
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $item["namamapel"] }}</td>
                    <td align="center">{{ $item["nilai"] }}</td>
                    <td class="fontku2" style="padding: 0;page-break-inside: avoid;">
                        <div>
                            @if ($item["agama"]==true && $item['ketAgama'] != "Islam")
                            {{ empty($item["catatanAgama"])?'-':$item["catatanAgama"] }}
                            @else
                            @if ($ket=="capaian")
                                {{ $item["capaian"] }}
                            @elseif($ket=="catatan")
                                {{ $item["catatan"] }}
                            @elseif($ket=="keduanya")
                                {{ $item["capaian"] }}
                            @endif

                            @endif
                        </div>

                        @if (!empty($item["capaian"]) && !empty($item["catatan"]) )
                        <hr style="border:0.5px solid grey;margin: 0;padding: 0;margin-top:5px">

                        @endif

                        <div>
                            @if ($item["agama"]==true && $item['ketAgama'] == "Islam")


                            @if ($ket=="keduanya")
                                {{ $item["catatan"] }}
                            @endif
                            @elseif($item["agama"]==false)
                            @if ($ket=="keduanya")
                                {{ $item["catatan"] }}
                            @endif
                            @endif
                        </div>

                    </td>



                </tr>



                @endif

            @endforeach


            </tbody>






        </table>

    </div>

    <br>

    <div class="fontku page" style="page-break-inside: avoid;">
        <b>
            B. Extrakulikuler
        </b>

        <table width="100%" class="tableku" border="1">
            <thead>
                <tr style="padding: 10px auto">
                    <th width="2px" style="page-break-inside: avoid;" style="padding: 10px auto">No</th>
                    <th style="page-break-inside: avoid;width: 200px" >Kegiatan Extrakulikuler</th>
                    <th style="page-break-inside: avoid;">Keterangan</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($extrakulikuler as $ex)
                <tr>
                    <td align="center" class="ukuran-judul">{{ $loop->iteration }}</td>
                    <td>{{ $ex->pembina->namaex }}</td>
                    <td>{{ $ex->nilai }}</td>
                </tr>

                @endforeach
                @if (count($extrakulikuler) == 0)
                <tr>
                    <td align="center" class="ukuran-judul">1</td>
                    <td>Pramuka</td>
                    <td>-</td>
                </tr>
                @endif
            </tbody>

        </table>
    </div>

    <br>

    @php
        $kehadiran = DB::table("kehadiran")->where("idsiswa", $siswa->idsiswa)
        ->where("idraport", $detail->idraport)->first();
    @endphp
    <div class="fontku">
        <b>
            C. Ketidak Hadiran
        </b>

        <table width="75%" class="tableku" border="1">
            <tbody>
                <tr>
                    <td style="width: 226px" class="ukuran-judul2">
                        Sakit
                    </td>
                    <td>
                        : &nbsp;{{ empty($kehadiran->sakit)?0:$kehadiran->sakit }}&nbsp;&nbsp;Hari
                    </td>
                </tr>
                <tr>
                    <td class="ukuran-judul2">
                        Izin
                    </td>
                    <td>
                        : &nbsp;{{ empty($kehadiran->izin)?0:$kehadiran->izin }}&nbsp;&nbsp;Hari
                    </td>
                </tr>
                <tr>
                    <td class="ukuran-judul2">
                        Tanpa Keterangan
                    </td>
                    <td>
                        : &nbsp;{{ empty($kehadiran->tanpaketerangan)?0:$kehadiran->tanpaketerangan }}&nbsp;&nbsp;Hari
                    </td>
                </tr>
            </tbody>

        </table>
    </div>

    <br>

    <div class="" style="page-break-inside: avoid;margin: 0;padding: 0;">

        @if (!($raport->namaraport == "raport uts") && $detail->semester != "ganjil")

            <div class="fontku">
                <b>
                    D. Kenaikan Kelas
                </b>

                <table width="100%" class="tableku" border="1">


                    <tbody>
                        <tr>
                            <td style="padding: 8px auto">
                                <center>
                                    <b>
                                        @if ($tidaklolos >= 3 || $tidaklolos2 > 0)
                                        <font style="color:red">
                                            TINGGAL KELAS
                                        </font>
                                        @else
                                        <font style="color:green">
                                            NAIK KELAS
                                        </font>
                                        @endif
                                    </b>
                                </center>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        @endif

        <br>

        <table width="100%">
            <tr>
                <td style="page-break-before: always;">
                    <div class="fontku">
                        <table width="100%">
                            <tr>
                                <td width="5%"></td>
                                <td width="50%">

                                        <p>Orang Tua/Wali</p>
                                        <br>
                                        <br>
                                        <br>
                                        <p>. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . </p>
                                </td>

                                <td width="40%">
                                        <p>Gunung Kijang, {{ \Carbon\Carbon::parse($raport->tanggal)->isoFormat("DD MMMM Y") }}</p>
                                        <p>Wali Kelas</p>
                                        <br>
                                        <br>
                                        <br>
                                        <p><b><u>{{ $identitas->first()->user->name }}</u></b></p>
                                        <p>{{ $identitas->first()->inip }}. {{ $identitas->first()->nip }}</p>

                                </td>
                            </tr>

                            <tr>
                                <td colspan="3">
                                    <center>
                                        <p>Mengetahui</p>
                                        <p>Kepala Sekolah</p>
                                        {{-- <img src="{{ url('gambar', ['ttd3.png']) }}" style="margin-top:-10px;margin-bottom:-10px;margin-left:0px" width="100px" alt=""> --}}
                                        <br>
                                        <br>
                                        <br>
                                        <p><b><u>MUSTAFA KAMAL, S.Pd</u></b></p>
                                        <p>NIP.19800909 201001 1 018</p>
                                    </center>

                                </td>
                            </tr>

                        </table>
                    </div>

                </td>
            </tr>

        </table>

    </div>


</body>
</html>
