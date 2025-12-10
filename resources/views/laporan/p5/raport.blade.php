@php
    $nomor = ["pertama", "pertama", "kedua", "ketiga", "keempat", "kelima"];
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NILAI RAPORT P5</title>
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
            margin: 5px auto;
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


        .fasphoto {
            float: right;
            border:1px solid grey;
            width: 113px;
            height: 151px;
            text-align: center;
            justify-content: center;
        }
        .fontku {
            font-size: 9.0pt;
        }
        .fontku2 {
            font-size: 8.5pt;
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
            /* margin-top: 120px; */
        }

        .justify {
            text-align: justify;
        }
        .text-bold {
            font-weight: bold;
        }
        /* header {
            position: fixed;
            top: 0;
            left: 0px;
            right: 0px;
            height: 50px;
        } */

    </style>
</head>
<body>

        <table width="100%" class="myfont tableku" style="margin: -13px auto">
            <tr>
                <td>
                    <center>
                        <h4>
                            RAPOR 
                            @if ($detail->dimensi == "p5")
                            PROJEK PENGUATAN PROFIL PELAJAR PANCASILA
                            @else
                            KOKURIKULER 
                            @endif

                        </h4>
                    </center>

                </td>
            </tr>
        </table>
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



    @php
        $bilangan = ["nomor", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh"];
    @endphp

    <table class="tableku fontku" border="1" width="100%">
        <tr>
            <td style="padding: 8px 15px">
                @foreach ($data as $item)
                <p style="font-weight: bold;">
                    @if ($detail->dimensi == "p5")
                    Projek {{ $loop->iteration }} | Tema : {{ $item['tema'] }}
                    @else
                    Tema : {{ $judulp5 }}
                    @endif

                
                </p>
                <p class="justify">Projek ini adalah projek {{ $nomor[$detail->nomor] }} dikelas {{ $detail->kelas->namakelas }}. projek ini diharapkan membangun {{ $bilangan[count($item['dimensi'])] }} dimensi 
                    @if ($detail->dimensi == "p5")
                    Profil Pelajar Pancasila,
                    @else
                    Profil Lulusan,
                    @endif
                    yakni

                @foreach ($item['dimensi'] as $d)
                    @php
                        if(($loop->iteration + 1) == count($item["dimensi"])) {
                            $pisah = " dan ";
                        }elseif($loop->iteration == count($item["dimensi"])) {
                            $pisah = ". ";
                        }
                        else {
                            $pisah = ", ";
                        }
                    @endphp
                    {{ $d["dimensi"].$pisah }}
                @endforeach
                Pada Projek ini peserta didik diharapkan mampu  untuk membangun Kesadaran dan keterampilan

                @php
                    $i1 = $detail->temap5->dimensip5->subdimensip5->count();
                    $i2 = 1;
                @endphp


                @foreach ($item['dimensi'] as $d)
                    @foreach ($d["subdimensi"] as $s)
                    @php
                        if(($i2 + 1) == $i1) {
                            $pisah = " dan ";
                        }elseif($i2 == $i1) {
                            $pisah = " ";
                        }
                        else {
                            $pisah = ", ";
                        }
                        $i2++;
                    @endphp
                    {{ $s["subdimensi"].$pisah }}

                    @endforeach


                @endforeach

                melalui projek 
                @if ($detail->dimensi == "p5")
                    <b>"{{ $judulp5 }}"</b>.
                @else
                    ini.
                @endif


                </p>

                @endforeach
            </td>
        </tr>
    </table>


    <table class="tableku fontku" width="100%" style="margin:6px auto">
        <tr>
            @foreach ($keteranganp5 as $k)
                <td valign="top" width="25%" style="padding:5px 15px">
                    <p style="font-weight: bold;margin: 0px;padding:0">
                        <input type="checkbox" style="font-size: 11px;margin-bottom:-3px">

                        &nbsp;{{ $k->keteranganp5 }}
                    </p>
                    <p style="margin: 0px;padding:0">{{ $k->deskripsi }}</p>
                </td>

            @endforeach
        </tr>
    </table>



    <table class="tableku fontku" border="1" width="100%" style="margin:6px auto">
        @foreach ($data as $d)
            <tr>
                <td width="70%" class="text-bold">Projek {{ $loop->iteration }} | Tema : {{ $d['tema'] }}</td>
                @foreach ($keteranganp5 as $k)
                    <td align="center" class="text-bold">{{ $k->inisialp5 }}</td>
                @endforeach
            </tr>

            @foreach ($d["dimensi"] as $dim)
                <tr>
                    <td style="padding:4px auto"  colspan="{{ count($keteranganp5) + 1 }}">{{ $dim["dimensi"] }}</td>
                </tr>
                @foreach ($dim["subdimensi"] as $s)
                    <tr>
                        <td>
                            <font class="text-bold">
                                {{ $s["subdimensi"] }}
                            </font>
                            <br>
                            {{ $s["deskripsi"] }}
                        </td>
                        @foreach ($s["nilai"] as $n)
                            <td align="center">
                                @if ($n == 1)
                                    V
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
        @endforeach

    </table>


    <table width="100%" class="tableku fontku" style="margin:6px auto">
        <tr>
            <td>
                <p class="text-bold" style="margin: 0;padding:0">Catatan Kegiatan</p>
                <p class="justify" style="margin: 0;padding:0">
                    Ananda {{ $siswa->nama }} menunjukan kemampuan untuk


                    @php
                        $i1 = $detail->temap5->dimensip5->subdimensip5->count();
                        $i2 = 1;
                    @endphp
                    @foreach ($data as $d)
                        @foreach ($d["dimensi"] as $dim)
                            @foreach ($dim["subdimensi"] as $s)
                                @php
                                    if(($i2 + 1) == $i1) {
                                        $pisah = " dan ";
                                    }elseif($i2 == $i1) {
                                        $pisah = " ";
                                    }
                                    else {
                                        $pisah = ", ";
                                    }
                                    $i2++;
                                @endphp

                                {{ $s["subdimensi"] }}
                                dalam tahap
                                @foreach ($s["keterangan"] as $sk)
                                    {{ $sk["keterangan"].$pisah }}
                                @endforeach

                            @endforeach
                        @endforeach
                    @endforeach
                    melalui projek <b>"{{ $judulp5 }}"</b>.
                </p>

            </td>
        </tr>
    </table>

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
                                    <br>
                                    <p>. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . </p>
                            </td>

                            <td width="40%">
                                    <p>Gunung Kijang, {{ \Carbon\Carbon::parse('2025-06-26')->isoFormat("DD MMMM Y") }}</p>
                                    <p>Wali Kelas</p>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <p style="padding: 0 auto;margin:0 auto"><b><u>{{ Auth::user()->name }}</u></b></p>
                                    <p style="padding: 0 auto;margin:0 auto">{{ Auth::user()->identitas->inip }}. {{ Auth::user()->identitas->nip }}</p>

                            </td>
                        </tr>

                        {{-- <tr>
                            <td colspan="3">
                                <center>
                                    <p>Mengetahui</p>
                                    <p>Kepala Sekolah</p>
                                    <img src="{{ url('gambar', ['ttd3.png']) }}" style="margin-top:-10px;margin-bottom:-10px;margin-left:0px" width="100px" alt="">
                                    <p><b>MUSTAFA KAMAL, S.Pd</b></p>
                                    <p>NIP.19800909 201001 1 018</p>
                                </center>

                            </td>
                        </tr> --}}

                    </table>
                </div>

            </td>
        </tr>

    </table>


</body>
</html>
