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
            font-size: 8.5pt;
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
                        LAPORAN ASESMEN TENGAH SEMESTER GANJIL <br>
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
                        <td valign="top">{{ $siswa->kelas->namakelas." ".$siswa->jurusan->jurusan }}</td>
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

    <div class="fontku">
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
                <td colspan="4" >A. Kelompok Mata Pelajaran Umum</td>
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
                @endphp
                
                @if ($item["ket"]=="umum")
                <tr>
                    <td rowspan="{{ $nilai }}" align="center">{{ $loop->iteration }}</td>
                    <td rowspan="{{ $nilai }}">{{ $item["namamapel"] }}</td>
                    <td align="center" rowspan="{{ $nilai }}">{{ $item["nilai"] }}</td>
                    @if ($ket=="capaian")
                        <td style="page-break-before: always;" class="fontku2">{{ $item["capaian"] }}</td>
                    @elseif($ket=="catatan")
                        <td style="page-break-before: always;" class="fontku2">{{ $item["catatan"] }}</td>
                    @elseif($ket=="keduanya")
                        <td style="page-break-before: always;" class="fontku2">{{ $item["capaian"] }}</td>
                    @endif

                </tr>
                @if ($ket=="keduanya")
                <tr>
                    <td style="page-break-before: always;" class="fontku2"z>{{ $item["catatan"] }}</td>
                </tr>
                    
                @endif
                    
                @endif
                
            @endforeach
            

            <tr>
                <td colspan="4">B. Kelompok Mata Pelajaran Kejuruan</td>
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
                @endphp
                @if ($item["ket"]=="kejuruan")
                <tr>
                    <td rowspan="{{ $nilai }}" align="center">{{ $loop->iteration }}</td>
                    <td rowspan="{{ $nilai }}">{{ $item["namamapel"] }}</td>
                    <td align="center" rowspan="{{ $nilai }}">{{ $item["nilai"] }}</td>
                    @if ($ket=="capaian")
                        <td style="page-break-before: always;" class="fontku2">{{ $item["capaian"] }}</td>
                    @elseif($ket=="catatan")
                        <td style="page-break-before: always;" class="fontku2">{{ $item["catatan"] }}</td>
                    @elseif($ket=="keduanya")
                        <td style="page-break-before: always;" class="fontku2">{{ $item["capaian"] }}</td>
                    @endif

                </tr>
                    @if ($ket=="keduanya")
                    <tr>
                        <td style="page-break-before: always;" class="fontku2"z>{{ $item["catatan"] }}</td>
                    </tr>
                        
                    @endif

                @endif
                
            @endforeach


            </tbody>
            

            



        </table>

    </div>
    
    <br>
    
    <div class="fontku">
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
                <tr>
                    <td align="center">1</td>
                    <td>Pramuka</td>
                    <td>-</td>
                </tr>
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
                    <td style="width: 226px">
                        Sakit
                    </td>
                    <td>
                        : &nbsp;{{ empty($kehadiran->sakit)?0:$kehadiran->sakit }}&nbsp;&nbsp;Hari
                    </td>
                </tr>
                <tr>
                    <td>
                        Izin
                    </td>
                    <td>
                        : &nbsp;{{ empty($kehadiran->izin)?0:$kehadiran->izin }}&nbsp;&nbsp;Hari
                    </td>
                </tr>
                <tr>
                    <td>
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

    @if (!($raport->namaraport == "raport uts"))
        
        <div class="fontku">
            <b>
                E. Kenaikan Kelas
            </b>

            <table width="100%" class="tableku" border="1">
                

                <tbody>
                    <tr>
                        <td style="padding: 8px auto"> 
                            <center>
                                DALAM PENILAIAN
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
            <td class="page-break-before: always;">
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
                                    <p>Gunung Kijang, {{ \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat("DD MMMM Y") }}</p>
                                    <p>Wali Kelas</p>
                                    <br>
                                    <br>
                                    <br>
                                    <p><b>{{ $identitas->first()->user->name }}</b></p>
                                    <p>NIP.{{ $identitas->first()->nip }}</p>
            
                            </td>
                        </tr>
            
                        <tr>
                            <td colspan="3">
                                <center>
                                    <p>Mengetahui</p>
                                    <p>Kepala Sekolah</p>
                                    <img src="{{ url('gambar', ['ttd3.png']) }}" style="margin-top:-10px;margin-bottom:-10px;margin-left:0px" width="100px" alt="">
                                    <p><b>MUSTAFA KAMAL, S.Pd</b></p>
                                    <p>NIP.19800909 201001 1 018</p>
                                </center>
            
                            </td>
                        </tr>
            
                    </table>
                </div>

            </td>
        </tr>

    </table>
        
    
</body>
</html>