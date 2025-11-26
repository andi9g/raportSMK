@extends('layouts.master')

@section('cppklActive', 'active')
@section('warnapengaturancppkl', 'active')
@section("openpengaturan", "menu-is-opening menu-open")
@section("openpengaturanblock", "block")
@section("judul")
    PENGATURAN CAPAIAN PEMBELAJARAN PKL
@endsection

@section('content')
<div id="tambahcppkl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title-cppkl" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title-cppkl">Tambah Capaian Pembelajaran PKL</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('cppkl.store', []) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class='form-group'>
                         <label for="judulcppkl">Judul CP PKL</label>
                         <textarea class="form-control" name="judulcppkl" id="judulcppkl" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="index">Index</label>
                      <input type="number" class="form-control" name="index" id="index" aria-describedby="index" placeholder="" value="{{ $data->count() + 1 }}">
                      <small id="index" class="form-text text-muted">Posisi Text</small>
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
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahcppkl">Tambah Capaian Pembelajaran PKL</button>

                </div>
                <div class="col-md-4">
                        <form action="{{ url()->current() }}" method="get">
                        <div class='search-container'>
                            <input type='text' name="keyword" class='form-control search-input' onchange="submit()" placeholder='Search...' value="{{ $keyword??'' }}">
                            <i class='fas fa-search search-icon'></i>
                        </div>
                    </form>
                    </div>
                </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="5px">No</th>
                            <th>Nama Capaian Pembelajaran PKL</th>
                            <th>Elemen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data->count() == 0)
                            <tr>
                                <td colspan="3" align="center">Data tidak ditemukan</td>
                            </tr>
                        @endif
                        @foreach ($data as $item)
                        <tr>
                            <td align="center">{{ $loop->iteration + $data->firstItem() - 1 }}</td>
                            <td>{{ $item->judulcppkl }}</td>
                            <td width="5px">
                                <a href="{{ route('cppkl.show', [$item->idcppkl]) }}" class="badge badge-info badge-btn border-0 py-2"><i class="fa fa-eye"></i> Lihat Elemen CP</a>
                            </td>
                            <td nowrap>
                                <form action='{{ route('cppkl.destroy', [$item->idcppkl]) }}' method='post' class='d-inline'>
                                     @csrf
                                     @method('DELETE')
                                     <button type='submit' onclick="return confirm('Yakin ingin dihapus?')" class='badge badge-danger badge-btn border-0 py-1'>
                                         <i class="fa fa-trash"></i>
                                     </button>
                                </form>

                                <!-- Button trigger modal -->
                                <button type="button" class="badge badge-primary badge-btn border-0 py-1" data-toggle="modal" data-target="#edit{{ $item->idcppkl }}">
                                  <i class="fa fa-edit"></i>
                                </button>
                                
                                
                            </td>
                        </tr>


                        <!-- Modal -->
                        <div class="modal fade" id="edit{{ $item->idcppkl }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <form action="{{ route('cppkl.update', [$item->idcppkl]) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <div class="modal-body">
                                            <div class='form-group'>
                                                <label for="judulcppkl">Judul CP PKL</label>
                                                <textarea class="form-control" name="judulcppkl" id="judulcppkl" rows="3">{{ $item->judulcppkl }}</textarea>
                                            </div>
    
                                            <div class="form-group">
                                            <label for="index">Index</label>
                                            <input type="number" class="form-control" name="index" id="index" aria-describedby="index" placeholder="" value="{{ $item->index }}">
                                            <small id="index" class="form-text text-muted">Posisi Text</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
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
            {{ $data->links("vendor.pagination.bootstrap-4") }}
        </div>
    </div>


</div>

@endsection


