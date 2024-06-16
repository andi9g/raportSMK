@extends('layouts.master')

@section('warnaraportp5', 'active')

@section("judul", "Data Raport P5")

@section('content')

@if ($posisi == "admin")
<div class="container">
    <div id="tambahraportp5" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Tambah Raport P5</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tambah.raportp5', []) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="temap5">Masukan temap5</label>
                            <input id="temap5" class="form-control" type="text" placeholder="Masukan tema P5" name="tema">
                        </div>
                        <div class="form-group">
                            <label for="fase">Masukan Fase</label>
                            <input id="fase" class="form-control" type="text" placeholder="E, F..." name="fase">
                        </div>

                        <div class="form-group">
                            <label for="tahun">Tahun Ajaran</label>
                            <select id="tahun" class="form-control" name="tahun">

                                @php
                                    $urut = $tahun - 3;
                                @endphp
                                @for ($i = $urut; $i <= ($tahun+1); $i++)
                                    <option value="{{ $i }}" @if ($i == $tahun)
                                        selected
                                    @endif>{{ $i }}</option>
                                @endfor

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select id="semester" required class="form-control" name="semester">
                                <option value="">Pilih Semester</option>
                                <option value="ganjil">Ganjil</option>
                                <option value="genap">Genap</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Tambah Raport P5
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahraportp5">Tambah Raport P5</button>
                </div>
            </div>

        </div>
    </div>

</div>
@endif


<div class="container">
    <div class="row">
        @foreach ($raportp5 as $item)
        <div class="col-md-4">
            <div class="card card-outline card-secondary" style="box-shadow: 2px 2px 3px 2px rgba(0, 0, 0, 0.267)">
                <div class="card-header">
                    <h4 class="py-0 my-0 text-uppercase text-bold">
                        Raport p5
                    </h4>
                </div>
                <div class="card-body ">
                    <ul class="text-lg mb-0 ">
                        <li>TP. {{ $item->tahun."/".($item->tahun + 1) }}</li>
                        <li>SEMESTER {{ strtoupper($item->semester) }}</li>
                        <li>FASE {{ strtoupper($item->fase) }}</li>
                    </ul>

                    <center><h4 class="mt-2 pt-2 mb-0 pb-0 text-bold text-primary text-uppercase">{{ $item->tema }}</h4></center>

                </div>

                <div class="card-footer p-2 text-lg">
                    @if ($posisi == "admin" || $posisi == "walikelas")
                        <a href="{{ route('open.temap5', [$item->idraportp5]) }}" class="btn btn-block btn-danger text-bold">
                            KELOLA RAPORT P5
                        </a>

                        <a href="{{ route('penilaian.raportp5', [$item->idraportp5]) }}" class="btn btn-success btn-block text-bold">
                            PENILAIAN RAPORT P5
                        </a>

                    @else
                    @if (empty(Auth::user()->identitasp5->namaproject) && Auth::user()->identitasp5->count() > 0)
                        <button class="btn btn-success btn-block text-bold" type="button" data-toggle="modal" data-target="#tambahproject{{ $item->idraportp5 }}">PENILAIAN RAPORT P5</button>
                    @else
                        <a href="{{ route('penilaian.raportp5', [$item->idraportp5]) }}" class="btn btn-success btn-block text-bold">
                            PENILAIAN RAPORT P5
                        </a>
                    @endif

                    @endif





                </div>
            </div>

        </div>


        @endforeach

    </div>

</div>

@foreach ($raportp5 as $item)

@if (empty(Auth::user()->identitasp5->namaproject) && $posisi != "admin")
<div id="tambahproject{{ $item->idraportp5 }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Tambah Project Penilaian</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tambah.project.p5', [$item->idraportp5]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <input id="kelas" class="form-control" type="text" disabled value="{{ $idkelas }}">
                    </div>

                    <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <input id="jurusan" class="form-control" type="text" disabled value="{{ $idjurusan }}">
                    </div>

                    <div class="form-group">
                        <label for="namaproject">Nama Project Penilaian</label>
                        <input id="namaproject" class="form-control" type="text" name="namaproject" placeholder="contoh : Cegah Perundungan Dunia Maya">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Tambah Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endif
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
