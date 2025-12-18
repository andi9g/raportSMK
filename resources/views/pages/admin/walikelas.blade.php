@extends('layouts.master')

@section("walikelasAdmin", "active")
@section('judul', "Data Walikelas")

@section('content')
<div id="tambahwalikelas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title-walikelas" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title-walikelas">Tambah Walikelas</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('walikelasAdmin.store', []) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class='form-group'>
                        <label for='forididentitas' class='text-capitalize'>Identitas Guru</label>
                        <select name='ididentitas' id='forididentitas' class='form-control'>
                            @foreach ($identitas as $item)
                                <option value="{{ $item->ididentitas }}">{{ $item->user->name ?? "-" }}</option>
                            @endforeach
                        <select>
                    </div>

                    <div class='form-group'>
                        <label for='foridkelas' class='text-capitalize'>Kelas</label>
                        <select name='idkelas' id='foridkelas' class='form-control'>
                            @foreach ($kelas as $item)
                                <option value="{{ $item->idkelas }}">{{ $item->namakelas }}</option>
                            @endforeach
                        <select>
                    </div>
                    <div class='form-group'>
                        <label for='forjurusan' class='text-capitalize'>Jurusan</label>
                        <select name='jurusan' id='forjurusan' class='form-control'>
                            @foreach ($jurusan as $item)
                                <option value="{{ $item->idjurusan }}">{{ $item->jurusan }}</option>
                            @endforeach
                        <select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container-fluid">


    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-8">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahwalikelas">Tambah Walikelas</button>

                </div>
                <div class="col-md-4"></div>
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="5px">No</th>
                            <th>NIP</th>
                            <th>Nama Walikelas</th>
                            <th>Rombel</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($walikelas as $item)
                        <tr>
                            <td>{{ $loop->iteration + $walikelas->firstItem() - 1 }}</td>
                            <td>{{ $item->identitas->inip.". ".$item->identitas->nip }}</td>
                            <td>{{ $item->identitas->user->name }}</td>
                            <td>{{ $item->kelas->namakelas." ".$item->jurusan->jurusan }}</td>
                            <td nowrap>
                                <button class="badge bg-success badge-btn border-0 py-1" type="button" data-toggle="modal" data-target="#ubahwalikelas{{ $item->idwalikelas }}">
                                    <i class="fa fa-edit"></i> Ubah
                                </button>

                                <form action='{{ route('walikelasAdmin.destroy', [$item->idwalikelas]) }}' method='post' class='d-inline'>
                                     @csrf
                                     @method('DELETE')
                                     <button type='submit' onclick="return confirm('Yakin ingin dihapus?')" class='badge badge-danger badge-btn border-0 py-1'>
                                         <i class="fa fa-trash"></i>
                                     </button>
                                </form>
                            </td>
                        </tr>

                        <div id="ubahwalikelas{{ $item->idwalikelas }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="my-modal-title">Title</h5>
                                        <button class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('walikelasAdmin.update', [$item->ididentitas]) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <div class="modal-body">
                                            <div class='form-group'>
                                                <label for='foridentitas' class='text-capitalize'>Nama Walikelas</label>
                                                <input type='text' name='identitas' id='foridentitas' class='form-control' disabled value='{{ $item->identitas->user->name }}'>
                                            </div>
                                            <div class='form-group'>
                                                <label for='foridkelas' class='text-capitalize'>Kelas</label>
                                                <select name='idkelas' id='foridkelas' class='form-control'>
                                                    @foreach ($kelas as $k)
                                                        <option value="{{ $k->idkelas }}" @if ($item->idkelas == $k->idkelas)
                                                            selected
                                                        @endif>{{ $k->namakelas }}</option>
                                                    @endforeach
                                                <select>
                                            </div>
                                            <div class='form-group'>
                                                <label for='foridjurusan' class='text-capitalize'>Jurusan</label>
                                                <select name='idjurusan' id='foridjurusan' class='form-control'>
                                                    @foreach ($jurusan as $k)
                                                        <option value="{{ $k->idjurusan }}" @if ($item->idjurusan == $k->idjurusan)
                                                            selected
                                                        @endif>{{ $k->jurusan }}</option>
                                                    @endforeach
                                                <select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">UPDATE</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</div>

@endsection


