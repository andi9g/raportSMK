<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IDENTITAS RAPORT</title>
    <style>
        h2 {
            margin:0;
            padding:0;
            font-size: 14pt;
        }
        h1 {
            margin:0;
            padding:0;
            font-size: 17pt;
        }

        .page-break {
            page-break-before: always;
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
        .tableku {
            border-collapse: collapse;
            font-size: 8pt;
        }
        .tableku2 {
            border-collapse: collapse;
            font-size: 7pt;
        }

        .tableku tr th {
            line-height: 20px;

        }
        .tableku tr td {
            padding: 4px;
        }

        .vertical-th {
            writing-mode: vertical-lr; /* Vertical text, from right to left */
            transform: rotate(-30deg); /* Rotate 180 degrees to bring it up */
            /* white-space: nowrap;  */
            line-height: 10px;
            font-size: 7pt
        }

        .vertical-th-2 {
            writing-mode: vertical-lr; /* Vertical text, from right to left */
            transform: rotate(-30deg); /* Rotate 180 degrees to bring it up */
            /* white-space: nowrap;  */
            line-height: 10px;
            font-size: 6pt
        }

        body {
            font-size: 9pt;
            margin-top: -10;
        }

        table {
            border-collapse: collapse;
            height: auto;
            overflow: auto;
        }

        table {
            border-collapse: collapse;
            height: auto;
            overflow: auto;

        }


        th, td {
            padding: 8px;
            word-wrap: break-word;
            /* max-width: 100px; */
        }
        .pku {
            font-size: 11pt;
            line-height: 20px;
        }

        tr {
            page-break-inside: avoid;
        }
        .tdku {
            padding: 0;
            margin: 0;
        }
        .noborder {
            border-bottom: 1px double black;
        }
    </style>
</head>
<body>

    @foreach ($data as $item)
    <table width="100%" class="noborder">
        <tr>
            <td width="80px">
                <img src="{{ url('gambar', ['kepri.png']) }}" width="100%" alt="">
            </td>
            <td valign="top">
                <table width="100%">
                    <tr><td align="center" class="tdku"><h2>PEMERINTAH PROVINSI KEPULAUAN RIAU</h2></td></tr>
                    <tr><td align="center" class="tdku"><h1>DINAS PENDIDIKAN </h1></td></tr>
                    <tr><td align="center" class="tdku"><h1>SMK NEGERI 1 GUNUNG KIJANG</h1></td></tr>
                    <tr><td align="center" class="tdku">Jl. Poros Pulau Pucung-Lome,KM 48 Desa Malang Rapat Kecamatan Gunung Kijang Kode Pos 29153
                    </td></tr>
                    <tr><td align="center" class="tdku">Website : www.smkn1gunungkijang.sch.id Email : smkn1gunungkijang@yahoo.com
                    </td></tr>
                </table>
            </td>
            <td width="50px"></td>
        </tr>

    </table>
    <br>

    <table width="100%">
        <tr>
            <td class="tdku" align="center"><b>LEGER PENILAIAN {{ $item["judul"] }}</b></td>
        </tr>
        <tr>
            <td class="tdku" align="center"><b>TAHUN PELAJARAN {{ $item["tahun"] }}</b></td>
        </tr>
    </table>

    <table class="">
        <tr>
            <td class="tdku" width="70px">KELAS</td>
            <td class="tdku"> : &nbsp;</td>
            <td class="tdku">{{ $item["kelas"] }}</td>
        </tr>
        <tr>
            <td class="tdku">JURUSAN</td>
            <td class="tdku"> : &nbsp;</td>
            <td class="tdku">{{ $item["namajurusan"]." (".$item["jurusan"].")" }}</td>
        </tr>
    </table>


    <table border="1" class="@if ($item['jumlahmapel'] > 10)
        tableku2
    @else
        tableku
    @endif " width="100%">
        <thead>
            <tr>
                <th rowspan="3" width="5px" align="center">No</th>
                <th rowspan="3" nowrap>NAMA PESERTA</th>
                <th rowspan="3">NISN</th>
                <th colspan="{{ $item['jumlahmapel'] }}">NILAI</th>
                <th rowspan="3" ><p class="vertical-th">Jumlah Nilai</p></th>
                <th rowspan="3" ><p class="vertical-th">Nilai Rata-rata</p></th>
                <th rowspan="3" ><p class="vertical-th">Ket Lulus/Tidak Lulus</p></th>
            </tr>
            <tr>
                <th colspan="{{ $item['umum'] }}">Kelompok A</th>
                <th colspan="{{ $item['kejuruan'] }}">Kelompok B</th>
            </tr>
            <tr>
                @foreach ($item["mapel"] as $mapel)
                    @if ($mapel->mapel->ket == "umum")
                        <th><p class="vertical-th" >{{ $mapel->mapel->namamapel }}</p></th>

                    @endif
                @endforeach
                @foreach ($item["mapel"] as $mapel)
                    @if ($mapel->mapel->ket == "kejuruan" || $mapel->mapel->ket == "pilihan")
                        <th><p class="vertical-th">{{ $mapel->mapel->namamapel }}</p></th>
                    @endif
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($item["data"] as $siswa)
                <tr>
                    <td align="center">
                        {{ $loop->iteration }}
                    </td>
                    <td nowrap >
                        {{ ucwords(strtolower($siswa['namasiswa'])) }}
                    </td>
                    <td>{{ $siswa["nisn"] }}</td>
                    @foreach ($siswa["data"] as $mapel)
                        @if ($mapel["ket"] == "umum")
                            @if ($mapel['hasil'] < 65)
                            <td align="center" style="color:red">{{ $mapel["hasil"]}}</td>
                            @else
                            <td align="center">{{ $mapel["hasil"]}}</td>
                            @endif
                        @endif

                    @endforeach
                    @foreach ($siswa["data"] as $mapel)
                        @if ($mapel["ket"] == "kejuruan")
                            @if ($mapel['hasil'] < 65)
                            <td align="center" style="color:red">{{ $mapel["hasil"]}}</td>
                            @else
                            <td align="center">{{ $mapel["hasil"]}}</td>
                            @endif
                        @endif

                    @endforeach
                    <td align="center">{{ $siswa["jumlahnilai"] }}</td>
                    <td align="center">{{ $siswa["ratarata"] }}</td>
                    <td>
                        @if ($siswa["ratarata"] > 63)
                            LULUS
                        @else
                            TIDAK LULUS
                        @endif
                    </td>

            </tr>
            @endforeach
        </tbody>

    </table>

    <table width="100%">
        <tr>
            <td width="65%"></td>
            <td style="">
                <br>
                <p class="pku">
                    Gunung Kijang, {{ \Carbon\Carbon::parse(date('Y-m-d'))->isoFormat("DD MMMM YY") }} <br>
                    Wali Kelas {{ $item["kelas"] }} {{ $item["jurusan"] }}
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    @php

                        $walas = DB::table("walikelas")
                        ->join("identitas", "identitas.ididentitas", "walikelas.ididentitas")
                        ->select("identitas.iduser", "identitas.nip")
                        ->where("walikelas.idkelas", $item["idkelas"])
                        ->where("walikelas.idjurusan", $item["idjurusan"])->first();
                        $user = \App\Models\User::where("iduser", $walas->iduser)->first();
                    @endphp
                <b> <u> {{ $user->name }} </u> </b><br>
                <b>NIP. {{ $user->identitas->nip }}</b>
                </p>
            </td>
        </tr>

    </table>

    <div class="page-break"></div>

    @endforeach














</body>
</html>
