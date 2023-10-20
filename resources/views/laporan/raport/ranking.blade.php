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
        .vertical-th {
            writing-mode: vertical-lr; /* Vertical text, from right to left */
            transform: rotate(-15deg); /* Rotate 180 degrees to bring it up */
            /* white-space: nowrap;  */
            line-height: 10px;
            font-size: 7pt
        }
        body {
            font-size: 9pt;
        }

        table {
        width: 100%;
        border-collapse: collapse;
        height: auto;
    }

    th, td {
        border: 1px solid #000;
        padding: 8px;
    }

    tr {
        page-break-inside: avoid;
    }
    </style>
</head>
<body>
    <center>
        <h2>LAPORAN RANKING RAPOR</h2>
        <h2>SMKN 1 GUNUNG KIJANG</h2>
    </center>
        <br>
        <br>

        <table border="1" width="100%" class="tableku">
            <thead>
                <tr>
                    <th rowspan="2" width="5px">No</th>
                    <th rowspan="2" >Nama Peserta</th>
                    <th colspan="{{ count($mapel) }}">Mata Pelajaran</th>
                    <th rowspan="2">Rata-Rata</th>
                    <!-- Tambahkan <th> lainnya sesuai kebutuhan -->
                </tr>
                <tr>
                    @foreach ($mapel as $m)
                        <th style="width: 80px !important"><p class="vertical-th">{{ $m->mapel->namamapel }}</p></th>  
                    @endforeach
                </tr>

            </thead>
            <tbody>
                @foreach ($data as $d)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $d["namasiswa"] }}</td>
                    @foreach ($d["data"] as $item)
                        <td align="center">{{ $item["hasil"] }}</td>
                    @endforeach
                    <td align="center">{{ $d["ratarata"] }}</td>
                </tr>
                    
                @endforeach
                <!-- Tambahkan baris lainnya sesuai kebutuhan -->
            </tbody>
        </table>
        
        
        
        
        
        
        
        
        
        
        
        
        
    
</body>
</html>