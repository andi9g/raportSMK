@extends('layouts.master')

@section('warnamapel', 'active')

@section("judul", "Data Mapel")
@section('content')
    <div id="import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Import Data Mapel</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('mapel.import', []) }}" method="post" enctype="multipart/form-data">
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
                    <h5 class="modal-title" id="my-modal-title">Tambah Data Mapel</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('mapel.store', []) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namamapel">Nama Mapel</label>
                            <input id="namamapel" class="form-control" type="text" name="namamapel">
                        </div>
                        <div class="form-group">
                            <label for="ket">Keterangan</label>
                            <select id="ket" class="form-control" name="ket">
                                <option value="umum">Umum</option>
                                <option value="kejuruan">Kejuruan</option>
                                <option value="pilihan">Pilihan</option>
                            </select>
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
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahguru">Tambah Mapel</button>

                        <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#import">Import</button>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ url()->current() }}">
                            <div class="input-group">
                                <input class="form-control" type="text" name="keyword" placeholder="cari nama" aria-label="cari nama mapel" aria-describedby="cari" value="{{ $keyword }}">
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
                            <th>Nama Mapel</th>
                            <th>Ket</th>
                            <th>Aksi</th>
                        </thead>

                        <tbody>
                            @foreach ($mapel as $item)
                            <tr>
                                <td width="5px">{{ $loop->iteration + $mapel->firstItem() - 1 }}</td>
                                <td>{{ $item->namamapel }}</td>
                                <td>{{ $item->ket }}</td>


                                <td>
                                    <form action="{{ route('mapel.destroy', [$item->idmapel]) }}" method="post" class="d-inline">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('Yakin ingin dihapus?')" class="badge badge-danger border-0 py-1">
                                            <i class="fa fa-trash"></i>Hapus
                                        </button>
                                    </form>


                                    <button class="badge border-0 py-1 badge-primary" type="button" data-toggle="modal" data-target="#edit{{ $item->idmapel }}">
                                        <i class="fa fa-edit"></i>
                                        Ubah
                                    </button>


                                </td>
                            </tr>

                            <div id="edit{{ $item->idmapel }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="my-modal-title">Form Ubah</h5>
                                            <button class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('mapel.update', [$item->idmapel]) }}" method="post">
                                            @csrf
                                            @method("PUT")
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="namamapel">Nama Mapel</label>
                                                    <input id="namamapel" class="form-control" type="text" name="namamapel" value="{{ $item->namamapel }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="ket">Keterangan</label>
                                                    <select id="ket" class="form-control" name="ket">
                                                        <option value="umum" @if ($item->ket=="umum")
                                                            selected
                                                        @endif>Umum</option>
                                                        <option value="kejuruan" @if ($item->ket=="kejuruan")
                                                            selected
                                                        @endif>Kejuruan</option>
                                                        <option value="pilihan" @if ($item->ket=="pilihan")
                                                            selected
                                                        @endif>Pilihan</option>
                                                    </select>
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
                    {{ $mapel->links("vendor.pagination.bootstrap-4") }}
                </div>
            </div>
        </div>

    </div>

@endsection
