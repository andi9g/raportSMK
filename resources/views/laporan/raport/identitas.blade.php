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
        .fasphoto2 {
            float: right;
            width: 113px;
            height: 151px;
            text-align: center;
            justify-content: center;
        }
        
    </style>
</head>
<body>
    <center>
        <h2>IDENTITAS PESERTA DIDIK</h2>
    </center>
        <br>
        <br>

    <table border="0" width="100%" class="identitas">
        <tr>
            <td nowrap valign="top">1.&nbsp;&nbsp;&nbsp;&nbsp; Nama Peserta Didik (lengkap)&nbsp;</td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ strtoupper(strtolower($siswa->nama))}}</td>
        </tr>

        <tr>
            <td nowrap valign="top">2.&nbsp;&nbsp;&nbsp;&nbsp; Nomor Induk/NISN</td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower(sprintf('%010s',$siswa->nisn)))}}</td>
        </tr>

        <tr>
            <td nowrap valign="top">3.&nbsp;&nbsp;&nbsp;&nbsp; Tempat dan Tanggal Lahir &emsp;</td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->tempatlahir))}}, {{ \Carbon\Carbon::parse($siswa->tanggallahir)->isoFormat("DD MMMM Y") }}</td>
        </tr>

        <tr>
            <td nowrap valign="top">4.&nbsp;&nbsp;&nbsp;&nbsp; Jenis Kelamin</td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">@if ($siswa->jk == "L")
                Laki-laki
                @else
                Perempuan
            @endif</td>
        </tr>
        <tr>
            <td nowrap valign="top">5.&nbsp;&nbsp;&nbsp;&nbsp; Agama</td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->agama))}}</td>
        </tr>
        <tr>
            <td nowrap valign="top">6.&nbsp;&nbsp;&nbsp;&nbsp; Status dalam Keluarga</td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->statusdalamkeluarga))}}</td>
        </tr>

        <tr>
            <td nowrap valign="top">7.&nbsp;&nbsp;&nbsp;&nbsp; Anak ke</td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->anakke))}}</td>
        </tr>
        <tr>
            <td nowrap valign="top">8.&nbsp;&nbsp;&nbsp;&nbsp; Alamat Peserta Didik</td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->alamat))}}</td>
        </tr>
        <tr>
            <td nowrap valign="top">9.&nbsp;&nbsp;&nbsp;&nbsp; Nomor Telp/HP</td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->hp))}}</td>
        </tr>
        <tr>
            <td nowrap valign="top">10.&nbsp;&nbsp; Asal Sekolah</td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ $siswa->asalsekolah}}</td>
        </tr>
        {{-- sub point --}}
        <tr>
            <td nowrap valign="top" colspan="3">11.&nbsp;&nbsp; Diterima di Sekolah ini</td>
        </tr>
        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.&nbsp;&nbsp; Di Kelas
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ $siswa->kelas->namakelas." ".$siswa->jurusan->jurusan}}</td>
        </tr>
        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.&nbsp;&nbsp; 
                Pada Tanggal
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ \Carbon\Carbon::parse($siswa->tanggalmasuk)->isoFormat("DD MMMM Y")}}</td>
        </tr>

        {{-- subpoint2 --}}
        <tr>
            <td nowrap valign="top" colspan="3">12.&nbsp;&nbsp; 
                Orang Tua
            </td>
        </tr>
        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.&nbsp;&nbsp; 
                Ayah
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->namaayah))}}</td>
        </tr>
        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.&nbsp;&nbsp; 
                Ibu
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->namaibu))}}</td>
        </tr>

        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.&nbsp;&nbsp; 
                Alamat Orang Tua
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->alamatortu))}}</td>
        </tr>

        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d.&nbsp;&nbsp; 
                Nomor Telp/HP
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->hportu))}}</td>
        </tr>

        {{-- subpoint3 --}}
        <tr>
            <td nowrap valign="top" colspan="3">13.&nbsp;&nbsp; 
                Pekerjaan Orang Tua
            </td>
        </tr>
        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.&nbsp;&nbsp; 
                Ayah
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->pekerjaanayah))}}</td>
        </tr>
        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.&nbsp;&nbsp; 
                Ibu
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->pekerjaanibu))}}</td>
        </tr>

        {{-- subpoint3 --}}
        <tr>
            <td nowrap valign="top" colspan="3">14.&nbsp;&nbsp; 
                Wali Peserta Didik
            </td>
        </tr>
        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a.&nbsp;&nbsp; 
                Nama Wali
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->namawali))}}</td>
        </tr>
        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b.&nbsp;&nbsp; 
                Nomor Telp/HP
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->hpwali))}}</td>
        </tr>
        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c.&nbsp;&nbsp; 
                Alamat Wali
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->alamatwali))}}</td>
        </tr>
        
        <tr>
            <td nowrap valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;d.&nbsp;&nbsp; 
                Pekerjaan
            </td>
            <td valign="top" style="width: fit-content">&nbsp;:&nbsp;</td>
            <td valign="top" width="100%">{{ ucwords(strtolower($siswa->pekerjaanwali))}}</td>
        </tr>
    </table>
    <br>
    <table width="100%">
        <tr>
            <td width="40%" align="right" style="padding-top: 10px">
                @if (!empty($siswa->foto))
                <img src="{{ url('gambar/siswa', [$siswa->foto]) }}" width="113.38" height="151.18" alt="">
                    

                @else
                <div class="@if (!empty($siswa->gambar->gambar))
                    fasphoto2
                    @else
                    fasphoto
                @endif ">
                    @if (!empty($siswa->gambar->gambar))
                    <center>
                        <img src="https://absen.smkn1gunungkijang.sch.id/gambar/siswa/{{ $siswa->gambar->gambar }}" width="95%" style="border: 2px solid white" alt="">
                    </center>
                    @else
                    <br>
                    <br>
                    <br>
                    PAS PHOTO 
                    <br>
                    3X4

                    @endif
                </div>

                @endif

            </td>
            <td></td>
            <td width="55%" valign="top">
                <p>Gunung Kijang, {{ \Carbon\Carbon::parse(date("Y-m-d"))->isoFormat("DD MMMM Y") }}</p>
                <p>Kepala Sekolah</p>
                {{-- <img src="{{ url('gambar', ['ttd3.png']) }}" style="margin-top:-25px;margin-bottom:-10px;margin-left:20px" width="130px" alt=""> --}}
                <br><br><br><br>
                <p style="margin: 0 uto;padding:0 auto">
                    <b>
                        <u>
                            MUSTAFA KAMAL,S.Pd
                        </u>
                    </b>
                </p>
                <p style="margin: 0 uto;padding:0 auto">
                    NIP. 19800909 201001 1 018
                </p>
            </td>
        </tr>
    </table>
        
    
</body>
</html>