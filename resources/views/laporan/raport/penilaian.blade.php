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
            
        }
        
        .tableku tr th {
            line-height: 20px;
        
        }
        .tableku tr td {
            padding: 4px;
        }
    </style>
</head>
<body>
    <center>
        <h2>LAPORAN PENILAIAN RAPOR</h2>
        <h2>SMKN 1 GUNUNG KIJANG</h2>
    </center>
        <br>
        <br>

    <table border="1" width="100%" class="tableku">
        <tr>
            <th rowspan="2" width="1px">NO</th>
            <th rowspan="2" width="300px" >NAMA SISWA</th>
            <th colspan="{{ count($elemen) }}" style="background: rgba(34, 241, 34, 0.589)">TUGAS</th>
            <th colspan="2" style="background: rgba(241, 227, 34, 0.589)">UJIAN</th>
            <th style="background: rgba(241, 82, 34, 0.589)">RATA-RATA</th>
        </tr>
        <tr>
            @foreach ($elemen as $e)
                <th>Nilai{{ $loop->iteration }}</th>
            @endforeach
            <th>Tes</th>
            <th>Non Tes</th>
            <th><small>(Tugas + Ujian) / 2</small></th>
        </tr>



        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ strtoupper($item["namasiswa"]) }}</td>
                    @foreach ($item["tugas"] as $tugas)
                        <td align="center">{{ $tugas["nilai"] }}</td>
                    @endforeach
                    <td align="center">{{ $item["praktek"] }}</td>
                    <td align="center">{{ $item["nonpraktek"] }}</td>
                    <td align="center">{{ $item["hasil"] }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>
        
    
</body>
</html>