@extends('layouts.master')

@section('warnaraport', 'active')

@section("judul", "CETAK RAPORT")
@if ($judul2 != null)
@section("judul2", $judul2)
@endif


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <a href="{{ url('raport', []) }}" class="btn btn-danger btn-md my-0 rounded-0">
                    <b>
                        Halaman Sebelumnya
                    </b>
                </a>
            </div>
            <div class="col-md-6 text-right">
               
            </div>
        </div>

        <div class="card mt-0">
            <div class="card-header">
                <form action="{{ url()->current() }}">
                    <div class="row">
                        @if (Auth::user()->identitas->posisi == "admin")
                            @php
                                $clas = "col-md-4";
                            @endphp
                        @else
                            @php
                                $clas = "col-md-8";
                            @endphp
                        @endif
                        <div class="{{ $clas }}">
                            <h3 class="m-0">RAPORT</h3>
                        </div>
                        @if (Auth::user()->identitas->posisi == "admin")
                        <div class="col-md-2">
                            <div class="form-group m-0">
                                    <select id="jurusan" class="form-control" name="jurusan" onchange="submit()">
                                        <option value="">Pilih Jurusan</option>
                                        @foreach ($datajurusan as $item)
                                        <option value="{{ $item->idjurusan }}" @if ($jurusan==$item->idjurusan)
                                            selected
                                        @endif>{{ $item->jurusan }}</option>
                                            
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group m-0">
                                <select id="kelas" class="form-control" name="kelas" onchange="submit()">
                                    <option value="">Pilih Kelas</option>
                                        @foreach ($datakelas as $item)
                                        <option value="{{ $item->idkelas }}" @if ($kelas==$item->idkelas)
                                            selected
                                        @endif>{{ $item->namakelas }}</option>
                                            
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        
                        @endif
                        <div class="col-md-4">
                            <div class="input-group">
                                <input class="form-control" type="text" name="keyword" placeholder="berdasarkan nama" aria-label="berdasarkan nama" aria-describedby="cari" value="{{ $keyword }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary px-3 ">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </form>
            </div>


            <div class="card-body pt-2">
                @if (Auth::user()->identitas->posisi != "admin")
                <a href="{{ route('ranking.raport', [$idraport]) }}" class="btn btn-secondary btn-md my-0 mb-2 rounded-0" target="_blank">
                    <b>
                        <i class="fa fa-print"></i> 
                        CETAK DETAIL RANKING SISWA
                    </b>
                </a>
                    
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered table-sm">
                        <thead class="bg-info">
                            <tr class="text-uppercase" valign="top">
                                <th rowspan="2" class="text-center" valign="top" width="5px">No</th>
                                <th rowspan="2" class="text-center">Nama</th>
                                <th rowspan="2" class="text-center">Edit</th>
                                <th rowspan="2" class="text-center">Kehadiran</th>
                                <th colspan="3" class="text-center">Cetak Raport</th>
                            </tr>
                            <tr class="text-uppercase">
                                <th class="text-center bg-danger">Cover</th>
                                <th class="text-center bg-warning">Identitas</th>
                                <th class="text-center bg-success">Nilai</th>
                            </tr>
                        </thead>
    
                        <tbody>
                            @foreach ($siswa as $item)
                            <tr>
                                <td>{{ $loop->iteration + $siswa->firstItem() - 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-center">
                                    <button class="badge border-0 py-1 px-2 badge-primary text-center" type="button" data-toggle="modal" data-target="#edit{{ $item->idsiswa }}">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                                <td>
                                    @php
                                        $kehadiran = DB::table("kehadiran")->where("idsiswa", $item->idsiswa)
                                        ->where("idraport", $idraport)->count();
                                        if($kehadiran == 0){
                                            $warna = "btn-danger";
                                        }else {
                                            $warna = "btn-success";
                                        }
                                    @endphp
                                    <button class="btn {{$warna}} btn-xs my-0" type="button" data-toggle="modal" data-target="#kehadiran{{ $item->idsiswa }}"><b>Kehadiran</b></button>
                                </td>
                                <td class="text-center">
                                    <a target="_blank" href="{{ route('cetak.cover', [$item->idsiswa]) }}" class="btn btn-xs btn-secondary">
                                        <i class="fa fa-print"></i>
                                        Cetak Cover
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a target="_blank" href="{{ route('cetak.identitas', [$item->idsiswa]) }}" class="btn btn-xs btn-warning text-dark">
                                        <i class="fa fa-print"></i>
                                        Cetak Identitas
                                    </a>
                                </td>

                                <td class="text-center">
                                    <a target="_blank" href="{{ route('cetak.nilai', [$item->idsiswa, $idraport]) }}" class="btn btn-block btn-xs btn-success">
                                        <b>
                                            <i class="fa fa-print"></i>
                                            Cetak Nilai
                                        </b>
                                    </a>
                                </td>
                            </tr>
                            
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer">
                {{ $siswa->links("vendor.pagination.bootstrap-4") }}
            </div>

        </div>
    </div>

    @foreach ($siswa as $item)
    <div id="kehadiran{{$item->idsiswa}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="kehadiransiswa" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="kehadiransiswa">KEHADIRAN <b>{{ $item->nama }}</b></h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tambah.kehadiran', [$idraport]) }}" method="post">
                    @csrf
                
                    <div class="modal-body">
                        @php
                            $kehadiran = DB::table("kehadiran")->where("idsiswa", $item->idsiswa)
                            ->where("idraport", $idraport)->first();
                        @endphp

                        <input type="text" name="idsiswa" value="{{ $item->idsiswa }}" hidden>

                        <div class="form-group">
                            <label for="izin">Izin</label>
                            <input id="izin" class="form-control" type="number" name="izin" value="{{ empty($kehadiran->izin)?'0':$kehadiran->izin }}">
                        </div>
                        <div class="form-group">
                            <label for="sakit">Sakit</label>
                            <input id="sakit" class="form-control" type="number" name="sakit" value="{{ empty($kehadiran->sakit)?'0':$kehadiran->sakit }}">
                        </div>
                        <div class="form-group">
                            <label for="tanpaketerangan">Tanpa Keterangan</label>
                            <input id="tanpaketerangan" class="form-control" type="number" name="tanpaketerangan" value="{{ empty($kehadiran->tanpaketerangan)?'0':$kehadiran->tanpaketerangan }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success px-4">
                            <b>
                                UPDATE KEHADIRAN
                            </b>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


        <div id="edit{{ $item->idsiswa }}" class="modal fade" tabindex="-99999" role="dialog" aria-labelledby="editsiswa" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editsiswa">Edit Data Siswa</h5>
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('siswa.update', [$item->idsiswa]) }}" method="post">
                        @csrf
                        @method("PUT")
                    
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input id="nisn" disabled class="form-control" type="number" value="{{ $item->nisn }}">
                            </div>
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input id="nis" class="form-control" type="number" name="nis" value="{{ $item->nis }}">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input id="nama" class="form-control" disabled type="text" value="{{ $item->nama }}">
                            </div>

                            <div class="form-group">
                                <label for="tempatlahir">Tempat Lahir</label>
                                <input id="tempatlahir" class="form-control" type="text" name="tempatlahir" value="{{ $item->tempatlahir }}">
                            </div>

                            <div class="form-group">
                                <label for="tanggallahir">Tanggal Lahir</label>
                                <input id="tanggallahir" class="form-control" type="date" name="tanggallahir" value="{{ $item->tanggallahir }}">
                            </div>

                            <div class="form-group">
                                <label for="jeniskelamin">Jenis Kelamin</label>
                                <select id="jeniskelamin" class="form-control" name="jk">
                                    <option value="L" @if ($item->jk=="L")
                                        selected
                                    @endif>Laki-Laki</option>
                                    <option value="P" @if ($item->jk=="P")
                                        selected
                                    @endif>Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="agama">Agama</label>
                                <select id="agama" class="form-control" name="agama">
                                    <option>Tidak Terdefinisi</option>
                                    @php
                                        $agama = [
                                            "Islam",
                                            "Kristen Protestan", 
                                            "Kristen Katolik", 
                                            "Hindu", 
                                            "Buddha", 
                                            "Khonghucu"
                                        ];
                                    @endphp 
                                    @foreach ($agama as $a)
                                        <option value="{{ $a }}" @if ($item->agama == $a)
                                            selected
                                        @endif>{{ $a }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="namaayah">Nama Ayah</label>
                                <input id="namaayah" class="form-control" type="text" value="{{ $item->namaayah }}" name="namaayah">
                            </div>

                            <div class="form-group">
                                <label for="namaibu">Nama Ibu</label>
                                <input id="namaibu" class="form-control" type="text" value="{{ $item->namaibu }}" name="namaibu">
                            </div>
                            <div class="form-group">
                                <label for="alamatortu">Alamat Orang Tua</label>
                                <input id="alamatortu" class="form-control" type="text" value="{{ $item->alamatortu }}" name="alamatortu">
                            </div>

                            <div class="form-group">
                                <label for="hportu">No HP Ortu</label>
                                <input id="hportu" class="form-control" type="text" value="{{ $item->hportu }}" name="hportu">
                            </div>

                            <div class="form-group">
                                <label for="statusdalamkeluarga">Status Dalam Keluarga</label>
                                <input id="statusdalamkeluarga" class="form-control" type="text" value="{{ $item->statusdalamkeluarga }}" name="statusdalamkeluarga">
                            </div>

                            <div class="form-group">
                                <label for="anakke">Anak Ke</label>
                                <input id="anakke" class="form-control" type="number" value="{{ $item->anakke }}" name="anakke">
                            </div>

                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input id="alamat" class="form-control" type="text" name="alamat" value="{{ $item->alamat }}">
                            </div>

                            <div class="form-group">
                                <label for="hp">No HP</label>
                                <input id="hp" class="form-control" type="number" name="hp" value="{{ $item->hp }}">
                            </div>

                            <div class="form-group">
                                <label for="asalsekolah">Asal Sekolah</label>
                                <input id="asalsekolah" class="form-control" type="text" name="asalsekolah" value="{{ $item->asalsekolah }}">
                            </div>

                            <div class="form-group">
                                <label for="tanggalmasuk">Tanggal Masuk</label>
                                <input id="tanggalmasuk" class="form-control" type="date" name="tanggalmasuk" value="{{ $item->tanggalmasuk }}">
                            </div>
                            <div class="form-group">
                                <label for="pekerjaanayah">Pekerjaan Ayah</label>
                                <input id="pekerjaanayah" class="form-control" type="text" name="pekerjaanayah" value="{{ $item->pekerjaanayah }}">
                            </div>

                            <div class="form-group">
                                <label for="pekerjaanibu">Pekerjaan Ibu</label>
                                <input id="pekerjaanibu" class="form-control" type="text" name="pekerjaanibu" value="{{ $item->pekerjaanibu }}">
                            </div>

                            <div class="form-group">
                                <label for="namawali">Nama Wali</label>
                                <input id="namawali" class="form-control" type="text" name="namawali" value="{{ $item->namawali }}">
                            </div>

                            <div class="form-group">
                                <label for="hpwali">No HP Wali</label>
                                <input id="hpwali" class="form-control" type="number" name="hpwali" value="{{ $item->hpwali }}">
                            </div>

                            <div class="form-group">
                                <label for="alamatwali">Alamat Wali</label>
                                <input id="alamatwali" class="form-control" type="text" name="alamatwali" value="{{$item->alamatwali}}">
                            </div>

                            <div class="form-group">
                                <label for="pekerjaanwali">Pekerjaan Wali</label>
                                <input id="pekerjaanwali" class="form-control" type="text" name="pekerjaanwali" value="{{ $item->pekerjaanwali }}">
                            </div>
                        </div>

                        <div class="modal-footer text-right">
                            <button type="submit" class="btn btn-success px-3">EDIT DATA SISWA</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection