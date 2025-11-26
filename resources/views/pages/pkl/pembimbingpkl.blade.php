@extends('layouts.master')

@section('pembimbingpklActive', 'active')
{{-- @section('warnapengaturanpembimbingpkl', 'active') --}}

@section("judul")
    PENGATURAN PEMBIMBING PKL
@endsection

@section('content')
<div id="tambahwalikelas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title-pembimbingpkl" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title-pembimbingpkl">Tambah Pembimbing PKL</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pembimbingpkl.store', []) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class='form-group'>
                        <label for='forididentitas' class='text-capitalize'>Identitas Guru</label>
                        <select name='iduser' id='forididentitas' class='form-control'>
                            @foreach ($identitas as $item)
                                <option value="{{ $item->iduser }}">{{ $item->name ?? "-" }}</option>
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
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahwalikelas">Tambah Pembimbing PKL</button>

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
                            <th>Nama Pembimbing PKL</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($pembimbingpkl->count() == 0)
                            <tr>
                                <td colspan="3" align="center">Data tidak ditemukan</td>
                            </tr>
                        @endif
                        @foreach ($pembimbingpkl as $item)
                        <tr>
                            <td>{{ $loop->iteration + $pembimbingpkl->firstItem() - 1 }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td nowrap>
                                <form action='{{ route('pembimbingpkl.destroy', [$item->idpembimbingpkl]) }}' method='post' class='d-inline'>
                                     @csrf
                                     @method('DELETE')
                                     <button type='submit' onclick="return confirm('Yakin ingin dihapus?')" class='badge badge-danger badge-btn border-0 py-1'>
                                         <i class="fa fa-trash"></i>
                                     </button>
                                </form>
                            </td>
                        </tr>


                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
        <div class="card-footer">
            {{ $pembimbingpkl->links("vendor.pagination.bootstrap-4") }}
        </div>
    </div>


</div>

@endsection


