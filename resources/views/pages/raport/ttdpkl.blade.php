@extends('layouts.master')

@section('warnaraportpkl', 'active')

@section("judul", "Data TTD Raport PKL")
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col">
                <a href="{{ url('raporpkl', []) }}" class="btn btn-danger mb-3"> < Kembali</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <center>
                        <h3>WALIKELAS PKL</h3>
                    </center>
                </div>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#tambahwalikelas">
                      Tambah Walikelas PKL
                    </button>


                    <table class="table table-bordered table-striped table-hover mt-2">
                        <thead>
                            <tr>
                                <th width="5px">NO</th>
                                <th>Nama Walikelas</th>
                                <th>Jurusan</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($walikelaspkl as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->jurusan->jurusan }}</td>
                                    <td>
                                        <form action='{{ route('hapusttd.walikelas', [$item->idwalikelaspkl]) }}' method='post' class='d-inline'>
                                             @csrf
                                             @method('DELETE')
                                             <button type='submit' class='badge badge-danger badge-btn border-0'>
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
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <center>
                        <h3>KAJUR PKL</h3>
                    </center>
                </div>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#tambahkajur">
                      Tambah Kajur PKL
                    </button>


                    <table class="table table-bordered table-striped table-hover mt-2">
                        <thead>
                            <tr>
                                <th width="5px">NO</th>
                                <th>Nama kajur</th>
                                <th>Jurusan</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kajurpkl as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->jurusan->jurusan }}</td>
                                    <td>
                                        <form action='{{ route('hapusttd.kajur', [$item->idkajurpkl]) }}' method='post' class='d-inline'>
                                             @csrf
                                             @method('DELETE')
                                             <button type='submit' class='badge badge-danger badge-btn border-0'>
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
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <center>
                        <h3>KEPALA SEKOLAH PKL</h3>
                    </center>
                </div>
                <div class="card-body">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#tambahkepalasekolah">
                      Tambah Kepala Sekolah
                    </button>


                    <table class="table table-bordered table-striped table-hover mt-2">
                        <thead>
                            <tr>
                                <th width="5px">NO</th>
                                <th>Nama Walikelas</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kepalasekolahpkl as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        <form action='{{ route('hapusttd.kepalasekolah', [$item->idkepalasekolahpkl]) }}' method='post' class='d-inline'>
                                             @csrf
                                             @method('DELETE')
                                             <button type='submit' class='badge badge-danger badge-btn border-0'>
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
        </div>
        
    </div>
 

</div>




<!-- Modal -->
<div class="modal fade" id="tambahkepalasekolah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Kepala Sekolah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <form action="{{ route('tambahttd.kepalasekolah', [$idpkl]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class='form-group'>
                        <label for='foriduser' class='text-capitalize'>Nama kepala sekolah</label>
                        <select name='iduser' id='foriduser' class='form-control'>
                            <option value=''>Pilih</option>
                            @foreach ($user as $item)
                                <option value="{{ $item->iduser }}">{{ $item->name }}</option>
                            @endforeach
                        <select>
                            
                    </div>
    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahkajur" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah kajur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <form action="{{ route('tambahttd.kajur', [$idpkl]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class='form-group'>
                        <label for='foriduser' class='text-capitalize'>Nama kajur</label>
                        <select name='iduser' id='foriduser' class='form-control'>
                            <option value=''>Pilih</option>
                            @foreach ($user as $item)
                                <option value="{{ $item->iduser }}">{{ $item->name }}</option>
                            @endforeach
                        <select>
                            
                    </div>
    
                    <div class='form-group'>
                        <label for='foridjurusan' class='text-capitalize'>Jurusan</label>
                        <select name='idjurusan' id='foridjurusan' class='form-control'>
                            <option value=''>Pilih</option>
                            @foreach ($jurusan as $item)
                                <option value="{{ $item->idjurusan }}">{{ $item->jurusan }}</option>
                            @endforeach
                        <select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahwalikelas" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Tambah Walikelas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <form action="{{ route('tambahttd.walikelas', [$idpkl]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class='form-group'>
                        <label for='foriduser' class='text-capitalize'>Nama Walikelas</label>
                        <select name='iduser' id='foriduser' class='form-control'>
                            <option value=''>Pilih</option>
                            @foreach ($walikelas as $item)
                                <option value="{{ $item->identitas->user->iduser }}">{{ $item->identitas->user->name }}</option>
                            @endforeach
                        <select>
                            
                    </div>
    
                    <div class='form-group'>
                        <label for='foridjurusan' class='text-capitalize'>Jurusan</label>
                        <select name='idjurusan' id='foridjurusan' class='form-control'>
                            <option value=''>Pilih</option>
                            @foreach ($jurusan as $item)
                                <option value="{{ $item->idjurusan }}">{{ $item->jurusan }}</option>
                            @endforeach
                        <select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

 
@endsection
