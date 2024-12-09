@extends('layouts.master')

@section('warnaraport', 'active')

@section("judul")
KELOLA {{ strtoupper($judul) }}
@endsection
@section('content')
<div id="tambahdetailraport" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="my-modal-title">TAMBAH DATA {{ $judul }}</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tambah.detailraport', [$idraport]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Guru</label>
                        <input id="name" class="form-control" value="{{ $user->name }}" type="text" name="name" disabled>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <select required name="idkelas" class="form-control select2kelas" style="width: 100%;">
                            <option selected disabled><b>PILIH MAPEL</b></option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->idkelas }}">{{ $k->namakelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mata Pelajaran</label>
                        <select required name="idmapel" class="form-control select2mapel" style="width: 100%;">
                            <option selected disabled><b>PILIH MAPEL</b></option>
                            @foreach ($mapel as $m)
                                <option value="{{ $m->idmapel }}">{{ $m->namamapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mata Pelajaran</label>
                        <select required name="idjurusan" class="form-control select2jurusan" style="width: 100%;">
                            <option selected disabled><b>PILIH JURUSAN</b></option>
                            @foreach ($jurusan as $j)
                                <option value="{{ $j->idjurusan }}">[{{ $j->jurusan }}] - {{ $j->namajurusan }}</option>
                            @endforeach
                        </select>
                        <small><font class="text-red"><i>Jika mapel pilihan silahkan pilih jurusan mapel pilihan</i></font></small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">TAMBAH DATA</button>
                </div>
            </form>
        </div>
    </div>
</div>



   <div class="container">
    <a href="{{ url('raport', []) }}" class="btn btn-danger btn-sm my-0 rounded-0">Halaman Sebelumnya</a>
    <div class="card mt-0">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <button class="btn btn-primary mb-2 px-4" type="button" data-toggle="modal" data-target="#tambahdetailraport">
                        <span class="fa-tras"></span>
                        <b>Tambah Data</b>
                    </button>
                </div>
                <div class="col-md-4">
                    <form action="{{ url()->current() }}">
                        <div class="input-group">
                            <input class="form-control" type="text" name="keyword" placeholder="cari nama" aria-label="cari nama" aria-describedby="cari" value="{{ $keyword }}">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text" id="cari">
                                    <i class="fa fa-search"></i> Cari
                                </button >
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>

        <div class="card-body">
            <table class="table table-striped table-hover table-bordered table-sm text-md">
                <thead>
                    <th width="5px">No</th>
                    <th>Mapel</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>NILAI</th>
                    <th>AKSI</th>
                </thead>

                <tbody>
                    @foreach ($detailraport as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->mapel->namamapel }}</td>
                        <td>{{ $item->jurusan->jurusan }}
                            <button class="badge py-1 border-0 badge-info" type="button" data-toggle="modal" data-target="#editjurusandetail{{ $item->iddetailraport }}"><i class="fa fa-edit"></i></button>
                        </td>
                        <td>{{ $item->kelas->namakelas }}</td>
                        <td>
                            <a href="{{ url('nilairaport', [$item->iddetailraport]) }}" class="btn btn-success btn-block"><b>KELOLA NILAI</b></a>
                        </td>
                        <td>
                            <a target="_blank" href="{{ route('cetak.detailraport', [$item->iddetailraport]) }}" class="btn btn-secondary btn-block">
                                <b>
                                    <i class="fa fa-print"></i>
                                    CETAK
                                </b>
                            </a>
                            <button class="badge py-1 border-0 w-100 badge-danger" type="button" data-toggle="modal" data-target="#hapusdetailraport{{ $item->iddetailraport }}">
                                <i class="fa fa-trash"></i>
                            </button>
                            <button class="badge py-1 border-0 w-100 badge-primary" type="button" data-toggle="modal" data-target="#copydetailraport{{ $item->iddetailraport }}"><i class="fa fa-copy"></i> Duplikat </button>
                        </td>
                    </tr>

                    <div id="copydetailraport{{ $item->iddetailraport }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title-333333" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="my-modal-title-333333">Duplikat Mapel</h5>
                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('detailraport.ubah.duplikat', [$item->iddetailraport]) }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class='form-group'>
                                            <label for='forjurusan' class='text-capitalize'>Jurusan</label>
                                            <select name='jurusan' id='forjurusan' class='form-control'>
                                                <option value=''>Pilih</option>
                                                @foreach ($jurusan as $jr)
                                                    <option value="{{ $jr->idjurusan }}" @if ($jr->idjurusan == $item->idjurusan)
                                                        selected
                                                    @endif>{{ $jr->jurusan }}</option>
                                                @endforeach
                                            <select>
                                        </div>
                                    </div>
                                    <div class="modal-footer text-right">
                                        <button type="submit" class="btn btn-success">Ubah</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="editjurusandetail{{ $item->iddetailraport }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title-22222222" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="my-modal-title-22222222">Ubah Jurusan</h5>
                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('detailraport.ubah.jurusan', [$item->iddetailraport]) }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class='form-group'>
                                            <label for='forjurusan' class='text-capitalize'>Jurusan</label>
                                            <select name='jurusan' id='forjurusan' class='form-control'>
                                                <option value=''>Pilih</option>
                                                @foreach ($jurusan as $jr)
                                                    <option value="{{ $jr->idjurusan }}" @if ($jr->idjurusan == $item->idjurusan)
                                                        selected
                                                    @endif>{{ $jr->jurusan }}</option>
                                                @endforeach
                                            <select>
                                        </div>
                                    </div>
                                    <div class="modal-footer text-right">
                                        <button type="submit" class="btn btn-success">Ubah</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    <div id="hapusdetailraport{{ $item->iddetailraport }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="hapusdetailraport{{ $item->iddetailraport }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger">
                                    <h5 class="modal-title" id="hapusdetailraport{{ $item->iddetailraport }}">WARNING</h5>
                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-danger">YAKIN INGIN MENGHAPUS DATA YANG TELAH DI BUAT?

                                        <br>



                                    </p>
                                    <p>Jika menekan tombol setuju maka semua penilaian di dalamnya akan hilang.</p>
                                </div>
                                <div class="modal-footer text-right">
                                    <button class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                                        Batal
                                    </button>

                                    <form action="{{ route('hapus.detailraport', [$item->iddetailraport]) }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            SETUJU
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

   </div>


@endsection

@section('script')

    <script>
        $('.select2kelas').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#tambahdetailraport')
        });

        $('.select2mapel').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#tambahdetailraport')
        });
        $('.select2jurusan').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#tambahdetailraport')
        });
    </script>
@endsection
