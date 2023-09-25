<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COVER RAPORT</title>
    <style>
        h2 {
            margin:0;
            padding:0;
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
        
    </style>
</head>
<body>
    <center>
        <br>
        <br>
        <h2>RAPOR PESERTA DIDIK</h2>
        <h2>SMK NEGERI 1 GUNUNG KIJANG</h2>

        <br>
        <br>
        <br>
        <br>
        <img src="{{ url('gambar', ["pendidikan.png"]) }}" width="48%" alt="">
        <br>
        <br>
        <br>
        
        <br>
        <div class="fit">
            
        </div>

    </center>
    <p class="judul">
        Nama Peserta Didik:
    </p>
    <p class="nama">
        {{ strtoupper($siswa->nama) }} 
    </p>

    <p class="judul">
        NISN:
    </p>
    <p class="nama">
        {{ strtoupper($siswa->nisn) }} 
    </p>


    <center>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <h2>KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN REPUBLIK INDONESIA</h2>
    </center>
    
</body>
</html>