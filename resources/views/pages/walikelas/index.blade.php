@extends('layouts.master')

@section('warnawalikelas', 'active')

@section("judul", "Update Data WaliKelas")
@section('content')
   <div class="container">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="my-0">Data Walikelas</h3>
                    </div>
                </div>
                <form action="{{ route('walikelas.update', [$identitas->ididentitas]) }}" method="post">
                    @csrf
               
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input id="nama" class="form-control" type="text" disabled value="{{ $identitas->user->name }}">
                        </div>

                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select id="kelas" required class="form-control kelas" name="idkelas" >
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->idkelas }}">{{ $item->namakelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="jurusan">jurusan</label>
                            <select id="jurusan" required class="form-control jurusan" name="idjurusan" >
                                <option value="">Pilih jurusan</option>
                                @foreach ($jurusan as $item)
                                    <option value="{{ $item->idjurusan }}">{{ "[".$item->jurusan."]-".$item->namajurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success">Update Data Wali Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   </div>

@endsection