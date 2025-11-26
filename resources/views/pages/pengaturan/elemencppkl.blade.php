@extends('layouts.master')

@section('cppklActive', 'active')
@section('warnapengaturancppkl', 'active')
@section("openpengaturan", "menu-is-opening menu-open")
@section("openpengaturanblock", "block")
@section("judul")
    ELEMEN CP PKL
@endsection

@section('content')
<div id="tambahcppkl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title-cppkl" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title-cppkl">Tambah Elemen CP PKL</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tambah.elemen', []) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="number" name="idcppkl" hidden value="{{ $idcppkl }}">
                    <div class='form-group'>
                         <label for="judulelemencppkl">Judul Elemen CP PKL</label>
                         <textarea class="form-control" name="judulelemencppkl" id="judulelemencppkl" rows="3"></textarea>
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
                    <a class="btn btn-danger" href="{{ route('cppkl.index', []) }}">Kembali</a>
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahcppkl">Tambah Elemen CP PKL</button>

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
                            <th>Nama Elemen CP PKL</th>
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
                            <td>{{ $item->judulelemencppkl }}</td>
                            
                            <td nowrap>
                                <form action='{{ route('hapus.elemen', [$item->idelemencppkl]) }}' method='post' class='d-inline'>
                                     @csrf
                                     @method('DELETE')
                                     <button type='submit' onclick="return confirm('Yakin ingin dihapus?')" class='badge badge-danger badge-btn border-0 py-1'>
                                         <i class="fa fa-trash"></i>
                                     </button>
                                </form>

                                <!-- Button trigger modal -->
                                <button type="button" class="badge badge-primary badge-btn border-0 py-1" data-toggle="modal" data-target="#edit{{ $item->idelemencppkl }}">
                                  <i class="fa fa-edit"></i>
                                </button>
                                
                                
                            </td>
                        </tr>


                        <!-- Modal -->
                        <div class="modal fade" id="edit{{ $item->idelemencppkl }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                    </div>
                                    <form action="{{ route('ubah.elemen', [$item->idelemencppkl]) }}" method="post">
                                        @csrf
                                        @method("PUT")
                                        <div class="modal-body">
                                            {{-- <input type="number" name="idcppkl" hidden value="{{ $idcppkl }}"> --}}
                                            <div class='form-group'>
                                                <label for="judulelemencppkl">Judul Elemen CP PKL</label>
                                                <textarea class="form-control" name="judulelemencppkl" id="judulelemencppkl" rows="3">{!! $item->judulelemencppkl !!}</textarea>
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


