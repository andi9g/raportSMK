@extends('layouts.master')

@section('warnasiswa', 'active')

@section("judul", "Data Siswa")
@section('content')
    <div id="import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Import Data Siswa</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('siswa.import', []) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">File (xls/xlsx)</label>
                            <input id="file" class="form-control" type="file" name="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Import Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="tambahsiswa" class="modal fade" tabindex="-99999" role="dialog" aria-labelledby="editsiswa" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editsiswa">Tambah Data Siswa</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('siswa.store') }}" method="post">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nisn">NISN</label>
                            <input id="nisn" class="form-control" type="number" name="nisn" >
                        </div>
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input id="nis" class="form-control" type="number" name="nis">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input id="nama" class="form-control" name="nama" type="text" >
                        </div>

                        <div class="form-group">
                            <label for="tempatlahir">Tempat Lahir</label>
                            <input id="tempatlahir" class="form-control" type="text" name="tempatlahir" >
                        </div>

                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select id="kelas" class="form-control" name="idkelas">
                                @foreach ($kelas as $i)
                                <option value="{{ $i->idkelas }}">{{ $i->namakelas }}</option>

                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jurusan">jurusan</label>
                            <select id="jurusan" class="form-control" name="idjurusan">
                                @foreach ($jurusan as $i)
                                <option value="{{ $i->idjurusan }}">{{ $i->jurusan }}</option>

                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tanggallahir">Tanggal Lahir</label>
                            <input id="tanggallahir" class="form-control" type="date" name="tanggallahir" >
                        </div>

                        <div class="form-group">
                            <label for="jeniskelamin">Jenis Kelamin</label>
                            <select id="jeniskelamin" class="form-control" name="jk">
                                <option value="L" >Laki-Laki</option>
                                <option value="P" >Perempuan</option>
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
                                    <option value="{{ $a }}" >{{ $a }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="namaayah">Nama Ayah</label>
                            <input id="namaayah" class="form-control" type="text"  name="namaayah">
                        </div>

                        <div class="form-group">
                            <label for="namaibu">Nama Ibu</label>
                            <input id="namaibu" class="form-control" type="text"  name="namaibu">
                        </div>
                        <div class="form-group">
                            <label for="alamatortu">Alamat Orang Tua</label>
                            <input id="alamatortu" class="form-control" type="text"  name="alamatortu">
                        </div>

                        <div class="form-group">
                            <label for="hportu">No HP Ortu</label>
                            <input id="hportu" class="form-control" type="text"  name="hportu">
                        </div>

                        <div class="form-group">
                            <label for="statusdalamkeluarga">Status Dalam Keluarga</label>
                            <input id="statusdalamkeluarga" class="form-control" type="text"  name="statusdalamkeluarga">
                        </div>

                        <div class="form-group">
                            <label for="anakke">Anak Ke</label>
                            <input id="anakke" class="form-control" type="number"  name="anakke">
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input id="alamat" class="form-control" type="text" name="alamat" >
                        </div>

                        <div class="form-group">
                            <label for="hp">No HP</label>
                            <input id="hp" class="form-control" type="number" name="hp" >
                        </div>

                        <div class="form-group">
                            <label for="asalsekolah">Asal Sekolah</label>
                            <input id="asalsekolah" class="form-control" type="text" name="asalsekolah">
                        </div>

                        <div class="form-group">
                            <label for="tanggalmasuk">Tanggal Masuk</label>
                            <input id="tanggalmasuk" class="form-control" type="date" name="tanggalmasuk" >
                        </div>
                        <div class="form-group">
                            <label for="pekerjaanayah">Pekerjaan Ayah</label>
                            <input id="pekerjaanayah" class="form-control" type="text" name="pekerjaanayah" >
                        </div>

                        <div class="form-group">
                            <label for="pekerjaanibu">Pekerjaan Ibu</label>
                            <input id="pekerjaanibu" class="form-control" type="text" name="pekerjaanibu" >
                        </div>

                        <div class="form-group">
                            <label for="namawali">Nama Wali</label>
                            <input id="namawali" class="form-control" type="text" name="namawali" >
                        </div>

                        <div class="form-group">
                            <label for="hpwali">No HP Wali</label>
                            <input id="hpwali" class="form-control" type="number" name="hpwali" >
                        </div>

                        <div class="form-group">
                            <label for="alamatwali">Alamat Wali</label>
                            <input id="alamatwali" class="form-control" type="text" name="alamatwali" >
                        </div>

                        <div class="form-group">
                            <label for="pekerjaanwali">Pekerjaan Wali</label>
                            <input id="pekerjaanwali" class="form-control" type="text" name="pekerjaanwali" >
                        </div>
                    </div>

                    <div class="modal-footer text-right">
                        <button type="submit" class="btn btn-success px-3">TAMBAH DATA SISWA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahsiswa">Tambah Siswa</button>

                        <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#import">Import</button>
                    </div>
                    <div class="col-md-8">
                        <form action="{{ url()->current() }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class='form-group'>
                                    <select name='kelas' id='forkelas' onchange="submit()" class='form-control'>
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->namakelas }}" @if ($idkelas == $item->namakelas)
                                                selected
                                            @endif>{{ $item->namakelas }}</option>
                                        @endforeach
                                    <select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class='form-group'>
                                    <select name='keyjurusan' id='forkeyjurusan' onchange="submit()" class='form-control'>
                                        <option value="">Semua Jurusan</option>
                                        @foreach ($jurusan as $item)
                                            <option value="{{ $item->jurusan }}" @if ($keyjurusan == $item->jurusan)
                                                selected
                                            @endif>{{ $item->jurusan }}</option>
                                        @endforeach
                                    <select>
                                </div>
                            </div>
                            <div class="col-md-6">

                                    <div class="input-group">
                                        <input class="form-control" type="text" name="keyword" placeholder="cari nama" aria-label="cari nama siswa" aria-describedby="cari" value="{{ $keyword }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="input-group-text" id="cari">
                                                <i class="fa fa-search"></i> Cari
                                            </button >
                                        </div>
                                    </div>

                            </div>

                        </div>
                    </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-bordered table-hover">
                        <thead>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Rombel</th>
                            <th>Aksi</th>
                        </thead>

                        <tbody>
                            @foreach ($siswa as $item)
                            <tr>
                                <td width="5px">{{ $loop->iteration + $siswa->firstItem() - 1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->kelas->namakelas." ".$item->jurusan->jurusan }}</td>


                                <td>
                                    <form action="{{ route('siswa.destroy', [$item->idsiswa]) }}" method="post" class="d-inline">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('Yakin ingin dihapus?')" class="badge badge-danger border-0 py-1">
                                            <i class="fa fa-trash"></i>Hapus
                                        </button>
                                    </form>


                                    <button class="badge border-0 py-1 px-2 badge-primary text-center" type="button" data-toggle="modal" data-target="#edit{{ $item->idsiswa }}">
                                        <i class="fa fa-edit"></i>
                                        Ubah
                                    </button>


                                </td>
                            </tr>



                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer">
                <div class="table-responsive">
                    {{ $siswa->links("vendor.pagination.bootstrap-4") }}
                </div>
            </div>
        </div>

    </div>

    @foreach ($siswa as $item)

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
                                <label for="kelas">Kelas</label>
                                <select id="kelas" class="form-control" name="idkelas">
                                    @foreach ($kelas as $i)
                                    <option value="{{ $i->idkelas }}" @if ($item->idkelas == $i->idkelas)
                                        selected
                                    @endif>{{ $i->namakelas }}</option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="jurusan">jurusan</label>
                                <select id="jurusan" class="form-control" name="idjurusan">
                                    @foreach ($jurusan as $i)
                                    <option value="{{ $i->idjurusan }}" @if ($item->idjurusan == $i->idjurusan)
                                        selected
                                    @endif>{{ $i->jurusan }}</option>

                                    @endforeach
                                </select>
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
