<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IDENTITAS RAPORT</title>
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
        
    </style>
</head>
<body>
    <table width="100%" class="fontku">
        <tr>
            <td width="50%">
                <table width="100%">
                    <tr>
                        <td valign="top" nowrap>Nama Peserta Didik</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">{{ strtoupper($siswa->nama) }}</td>
                    </tr>
                    <tr>
                        <td valign="top" nowrap>Nomor Induk/NISN</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">{{ ucwords(strtolower($siswa->nisn)) }}</td>
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
            <td width="50%">
                <table width="100%">
                    <tr>
                        <td valign="top" nowrap>Kelas</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">{{ $siswa->kelas->namakelas." ".$siswa->jurusan->jurusan }}</td>
                    </tr>
                    <tr>
                        <td valign="top" nowrap>Fase</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">{{ strtoupper($detail->raport->fase) }}</td>
                    </tr>

                    <tr>
                        <td valign="top" nowrap>Semester</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">
                            {{ ucwords($detail->raport->semester) }}
                        </td>
                    </tr>

                    <tr>
                        <td valign="top" nowrap>Tahun Pelajaran</td>
                        <td valign="top" width="1px">:&nbsp;&nbsp;</td>
                        <td valign="top">
                            {{ $detail->raport->tahun."/".($detail->raport->tahun+1) }}
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

            <tr>
                <td colspan="4">A. Kelompok Mata Pelajaran Umum</td>
            </tr>
            @foreach ($mapel as $item)
                @if ($item["ket"]=="umum")
                <tr>
                    <td rowspan="2" align="center">{{ $loop->iteration }}</td>
                    <td rowspan="2">{{ $item["namamapel"] }}</td>
                    <td align="center" rowspan="2">{{ $item["nilai"] }}</td>
                    <td class="fontku2">Target Pembelajaran: {{ $item["capaian"] }}</td>
                </tr>
                <tr>
                    <td class="fontku2">{{ $item["catatan"] }}</td>
                </tr>
                    
                @endif
            @endforeach
            

            <tr>
                <td colspan="4">B. Kelompok Mata Pelajaran Kejuruan</td>
            </tr>
            @foreach ($mapel as $item)
            @if ($item["ket"]=="kejuruan")
            <tr>
                <td rowspan="2" align="center">{{ $loop->iteration }}</td>
                <td rowspan="2">{{ $item["namamapel"] }}</td>
                <td align="center" rowspan="2">{{ $item["nilai"] }}</td>
                <td class="fontku2">Target Pembelajaran: {{ $item["capaian"] }}</td>
            </tr>
            <tr>
                <td class="fontku2">{{ $item["catatan"] }}</td>
            </tr>
                
            @endif
        @endforeach



        </table>

    </div>
        
    
</body>
</html>