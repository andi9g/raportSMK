@extends('layouts.master')

@section('warnaraportp5', 'active')

@section("judul", "TEMA P5")

@section('content')
<div id="tambahtema" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Tema</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tambah.temap5', [$idraportp5]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="temap5">Tema P5</label>
                        <input id="temap5" class="form-control" type="text" placeholder="masukan tema p5" name="temap5">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Tambah Tema
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container">
    <a href="{{ url('raportp5', []) }}" class="btn btn-danger btn-sm my-0 rounded-0">Halaman Sebelumnya</a>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-primary text-bold" type="button" data-toggle="modal" data-target="#tambahtema">Tambah Tema P5</button>
                </div>
                
            </div>
            
        </div>

        <div class="card-body">
            @foreach ($temap5 as $item)
                <table class="table table-striped">
                    <tr>
                        <th class="text-lg">Projek {{ $loop->iteration }} | Tema : {{ $item->temap5 }}
                            &emsp;
                        <form action='{{ route('hapus.temap5', [$item->idtemap5]) }}' method='post' class='d-inline'>
                             @csrf
                             @method('DELETE')
                             <button type='submit' onclick="return confirm('yakin ingin menghapus tema?')" class='badge badge-danger py-1 border-0' style="font-size: 8px">
                                 <i class="fa fa-trash"></i>
                             </button>
                        </form>

                        <button class="badge py-1 border-0 badge-info" style="font-size: 8px" type="button" data-toggle="modal" data-target="#edittemap5{{ $item->idtemap5 }}">
                            <i class="fa fa-edit"></i>
                        </button>
                        </th>    
                    </tr>

                    <tr>
                        <td class="p-0">
                            @php
                                $dimensip5 = DB::connection("mysql")->table("dimensip5")->where("idtemap5", $item->idtemap5)->get();
                            @endphp
                            <button class="badge badge-success badge-btn border-0 text-bold" type="button" data-toggle="modal" data-target="#tambahdimensip5{{ $item->idtemap5 }}">Tambah Dimensi {{ $item->temap5 }}</button>
                            <ul>
                                @foreach ($dimensip5 as $dimensi)
                                    <li class="text-bold text-md">{{ $dimensi->dimensip5 }}
                                    &emsp;
                                    <form action='{{ route('hapus.dimensip5', [$dimensi->iddimensip5]) }}' method='post' class='d-inline'>
                                        @csrf
                                        @method('DELETE')
                                        <button type='submit' onclick="return confirm('yakin ingin menghapus dimensi?')" class='badge badge-danger py-1 border-0' style="font-size: 8px">
                                            <i class="fa fa-trash "></i>
                                        </button>
                                    </form>
            
                                    <button class="badge py-1 border-0 badge-info" style="font-size: 8px" type="button" data-toggle="modal" data-target="#editdimensip5{{ $dimensi->iddimensip5 }}">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    </li>
                                    <button class="badge badge-success badge-btn border-0 text-bold" type="button" data-toggle="modal" data-target="#tambahsubdimensip5{{ $dimensi->iddimensip5 }}">Tambah subdimensi</button>
                                    <ol>
                                        @php
                                            $subdimensip5 = DB::connection("mysql")->table("subdimensip5")->where("iddimensip5", $dimensi->iddimensip5)->get();
                                        @endphp
                                        @foreach ($subdimensip5 as $subdimensi)
                                        <li class="text-bold">{{ $subdimensi->subdimensip5 }}
                                            &emsp;
                                            <form action='{{ route('hapus.subdimensip5', [$subdimensi->idsubdimensip5]) }}' method='post' class='d-inline'>
                                                @csrf
                                                @method('DELETE')
                                                <button type='submit' onclick="return confirm('yakin ingin menghapus dimensi?')" class='badge badge-danger py-1 border-0' style="font-size: 8px">
                                                    <i class="fa fa-trash "></i>
                                                </button>
                                            </form>
                    
                                            <button class="badge py-1 border-0 badge-info" style="font-size: 8px" type="button" data-toggle="modal" data-target="#ubahsubdimensip5{{ $subdimensi->idsubdimensip5 }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </li>
                                        <p>{{ $subdimensi->deskripsi }}</p>
                                            
                                        @endforeach
                                    </ol>
                                @endforeach

                            </ul>
    
    
                        </td>

                    </tr>

                    
                </table>    


            @endforeach
        </div>
    </div>
</div>



@foreach ($temap5 as $item)
@php
    $dimensip5 = DB::connection("mysql")->table("dimensip5")->where("idtemap5", $item->idtemap5)->get();
@endphp

@foreach ($dimensip5 as $dimensi)
    @php
        $subdimensip5 = DB::connection("mysql")->table("subdimensip5")->where("iddimensip5", $dimensi->iddimensip5)->get();
    @endphp
    @foreach ($subdimensip5 as $subdimensi)
    <div id="ubahsubdimensip5{{ $subdimensi->idsubdimensip5 }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Ubah Subdimensi</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('ubah.subdimensip5', [$subdimensi->idsubdimensip5]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="subdimensip5">Subdimensi P5</label>
                            <input id="subdimensip5" class="form-control" placeholder="masukan subdimensi/point penilaian" type="text" value="{{ $subdimensi->subdimensip5 }}" name="subdimensip5">
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control" name="deskripsi" placeholder="masukan deskripsi dari subdimensi" rows="3">{{ $subdimensi->deskripsi }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Tambah Subdimensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    



    <div id="editdimensip5{{ $dimensi->iddimensip5 }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Ubah Dimensi Penilaian</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('ubah.dimensip5', [$dimensi->iddimensip5]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="dimensip5">Dimensi P5</label>
                            <input id="dimensip5" placeholder="masukan dimensi p5" class="form-control" value="{{ $dimensi->dimensip5 }}" type="text" name="dimensip5">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Ubah Dimensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="tambahsubdimensip5{{ $dimensi->iddimensip5 }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Tambah Subdimensi</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tambah.subdimensip5', []) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="number" hidden value="{{ $dimensi->iddimensip5 }}" name="iddimensip5">
    
                        <div class="form-group">
                            <label for="subdimensip5">Subdimensi P5</label>
                            <input id="subdimensip5" class="form-control" placeholder="masukan subdimensi/point penilaian" type="text" name="subdimensip5">
                        </div>
    
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control" name="deskripsi" placeholder="masukan deskripsi dari subdimensi" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Tambah Subdimensi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<div id="edittemap5{{ $item->idtemap5 }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Edit Tema P5</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('ubah.temap5', [$item->idtemap5]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="temap5">Tema P5</label>
                        <input id="temap5" class="form-control" value="{{ $item->temap5 }}" type="text" name="temap5">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Ubah Tema P5
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="tambahdimensip5{{ $item->idtemap5 }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Dimensi {{ $item->temap5 }}</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tambah.dimensip5', []) }}" method="post">
                @csrf
                <div class="modal-body">
                    <input id="idtema" hidden class="form-control" type="text" name="idtemap5" value="{{ $item->idtemap5 }}">

                    <div class="form-group">
                        <label for="dimensip5">Dimensi P5</label>
                        <input id="dimensip5" placeholder="masukan dimensi p5" class="form-control" type="text" name="dimensip5">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Tambah Dimensi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endforeach

@endsection





@section('script')
{{-- @foreach ($raport as $item)
    <script>
        $('.select2kelas{{ $loop->iteration }}').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#tambahdetailraport{{ $item->idraport }}')
        });

        $('.select2mapel{{ $loop->iteration }}').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#tambahdetailraport{{ $item->idraport }}')
        });
        $('.select2jurusan{{ $loop->iteration }}').select2({
            theme: 'bootstrap4',
            dropdownParent: $('#tambahdetailraport{{ $item->idraport }}')
        });
    </script>
    
@endforeach --}}
@endsection