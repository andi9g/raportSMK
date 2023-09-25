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
                    <th>CETAK</th>
                </thead>

                <tbody>
                    @foreach ($detailraport as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->mapel->namamapel }}</td>
                        <td>{{ $item->jurusan->jurusan }}</td>
                        <td>{{ $item->kelas->namakelas }}</td>
                        <td>
                            <a href="{{ url('nilairaport', [$item->iddetailraport]) }}" class="btn btn-success btn-block"><b>KELOLA NILAI</b></a>
                        </td>
                        <td>
                            <a href="{{ route('raport.view', [$item->iddetailraport]) }}" class="btn btn-secondary btn-block">
                                <b>
                                    <i class="fa fa-print"></i> CETAK RAPORT   
                                </b>
                            </a>
                        </td>
                    </tr>
                        
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