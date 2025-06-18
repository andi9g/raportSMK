@extends('layouts.master')

@section('warnaguru', 'active')
@section('judul', 'Data Guru')

@section('content')
    <div id="import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Import Data Guru</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('guru.import', []) }}" method="post" enctype="multipart/form-data">
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

    <div id="tambahguru" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Tambah Data Guru</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('guru.store', []) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input id="name" class="form-control" type="text" name="name">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" class="form-control" type="text" name="username">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" class="form-control" type="password" name="password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Tambah Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahguru">Tambah Guru</button>

                        <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#import">Import</button>
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
                <div class="table-responsive">
                    <table class="table table-striped table-sm table-bordered table-hover">
                        <thead>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Aksi</th>
                        </thead>

                        <tbody>
                            @foreach ($guru as $item)
                            <tr>
                                <td width="5px">{{ $loop->iteration + $guru->firstItem() - 1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->identitas->email ?? "-" }}</td>
                                <td>{{ $item->username }}</td>
                                <td>
                                    @if (Hash::check("guru2023", $item->password))
                                        guru2023
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>
                                    <form action="{{ route('guru.destroy', [$item->iduser]) }}" method="post" class="d-inline">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('Yakin ingin dihapus?')" class="badge badge-danger border-0 py-1">
                                            <i class="fa fa-trash"></i>Hapus
                                        </button>
                                    </form>


                                    <button class="badge border-0 py-1 badge-primary" type="button" data-toggle="modal" data-target="#edit{{ $item->iduser }}">
                                        <i class="fa fa-edit"></i>
                                        Ubah
                                    </button>

                                    <form action="{{ route('guru.reset', [$item->iduser]) }}" method="post" class="d-inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Yakin ingin direset?')" class="badge badge-warning border-0 py-1">
                                            <i class="fa fa-key"></i>Reset
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <div id="edit{{ $item->iduser }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="my-modal-title">Form Ubah</h5>
                                            <button class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('guru.update', [$item->iduser]) }}" method="post">
                                            @csrf
                                            @method("PUT")
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name">Nama Lengkap</label>
                                                    <input id="name" class="form-control" type="text" name="name" value="{{ $item->username }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input id="username" class="form-control" type="text" name="username" value="{{ $item->username }}">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">
                                                    UPDATE
                                                </button>
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

            <div class="card-footer">
                <div class="table-responsive">
                    {{ $guru->links("vendor.pagination.bootstrap-4") }}
                </div>
            </div>
        </div>

    </div>

@endsection
