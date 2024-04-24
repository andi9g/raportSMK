@extends('layouts.master')

@section('warnaraport', 'active')

@section("judul", "Data Raport")
@section('content')
@if ($user->identitas->posisi == "admin")
    <div id="tambahraport" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Form Tambah Raport</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('raport.store', []) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaraport">Judul Raport</label>
                            <select required id="namaraport" class="form-control" name="namaraport">
                                <option value="">Pilih</option>
                                <option value="raport uts" class="text-capitalize">Raport UTS</option>
                                <option value="raport semester" class="text-capitalize">Raport Semester</option>
                            </select>
                        </div>



                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select id="tahun" class="form-control" name="tahun" sele>
                                @php
                                    $tahun = ((int) date('Y')) - 3;
                                    $sekarang = ((int) date('Y'));
                                @endphp
                                @for ($i = $tahun; $i <= ((int) date('Y')); $i++)
                                    <option value="{{ $i }}" @if ($i == date("Y"))
                                        selected
                                    @endif>{{ $i }}</option>

                                @endfor
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select required id="semester" class="form-control" name="semester">
                                <option value="">Pilih..</option>
                                <option value="ganjil">Ganjil</option>
                                <option value="genap">Genap</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="fase">Kurikulum Merdeka Fase </label>
                            <input id="fase" class="form-control text-uppercase" type="text" name="fase" placeholder="contoh: E, F...">
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal Penerimaan Raport </label>
                            <input id="tanggal" class="form-control text-uppercase" type="date" name="tanggal" placeholder="">
                        </div>

                        <div class="form-group">
                            <label for="target">Target</label>
                            <select id="target" class="form-control" name="idtarget">
                                <option value="">Lewatkan</option>
                                @foreach ($ketraport as $ket)
                                    <option value="{{ $ket->idraport }}">{{ $ket->namaraport." [".$ket->semester."] Fase ".$ket->fase }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Tambah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif



   <div class="container">
        @if ($user->identitas->posisi == "admin")
            <div class="card">
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-7">
                        <button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#tambahraport">Tambah Raport</button>
                    </div>
                    <div class="col-md-5">
                        <form action="{{ url()->current() }}">
                            <div class="input-group">
                                <input class="form-control" type="text" name="keyword" placeholder="judul raport" aria-label="judul raport" aria-describedby="my-addon">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        @endif


        <div class="row">
            @foreach ($raport as $item)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header text-center">
                            <center>
                                <h2 class="card-title text-lg text-center"><b>{{ strtoupper($item->namaraport) }}</b></h2>
                            </center>
                            @if (Auth::user()->identitas->posisi == "admin")

                            <div class="float-right">
                                <form action="{{ route('raport.destroy', [$item->idraport]) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" onclick="return confirm('yakin ingin dihapus?')" class="btn">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="float-right">
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#ubahdata{{ $item->idraport }}">
                                    <i class="fa fa-edit text-white"></i>
                                </button>

                                <div id="ubahdata{{ $item->idraport }}" class="modal fade text-left" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="my-modal-title">Title</h5>
                                                <button class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('raport.update', [$item->idraport]) }}" method="post">
                                                @csrf
                                                @method("PUT")
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="namaraport">Judul Raport</label>
                                                        <select required id="namaraport" class="form-control" name="namaraport">
                                                            <option value="">Pilih</option>
                                                            <option value="raport uts" class="text-capitalize" @if ($item->namaraport=="raport uts")
                                                                selected
                                                            @endif>Raport UTS</option>
                                                            <option value="raport semester" class="text-capitalize" @if ($item->namaraport=="raport semester")
                                                                selected
                                                            @endif>Raport Semester</option>
                                                        </select>
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="tahun">Tahun</label>
                                                        <select id="tahun" class="form-control" name="tahun" sele>
                                                            @php
                                                                $tahun = ((int) date('Y')) - 3;
                                                                $sekarang = ((int) date('Y'));
                                                            @endphp
                                                            @for ($i = $tahun; $i <= ((int) date('Y')); $i++)
                                                                <option value="{{ $i }}" @if ($i == $item->tahun)
                                                                    selected
                                                                @endif>{{ $i }}</option>

                                                            @endfor
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="semester">Semester</label>
                                                        <select required id="semester" class="form-control" name="semester">
                                                            <option value="">Pilih..</option>
                                                            <option value="ganjil" @if ($item->semester == "ganjil")
                                                                selected
                                                            @endif>Ganjil</option>
                                                            <option value="genap" @if ($item->semester == "genap")
                                                                selected
                                                            @endif>Genap</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="fase">Kurikulum Merdeka Fase </label>
                                                        <input id="fase" class="form-control text-uppercase" type="text" name="fase" placeholder="contoh: E, F..." value="{{ $item->fase }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="tanggal">Tanggal Penerimaan Raport </label>
                                                        <input id="tanggal" class="form-control text-uppercase" type="date" name="tanggal" placeholder="" value="{{ $item->tanggal }}">
                                                    </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Ubah Data</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            @endif
                        </div>

                        <div class="card-body text-lg">
                            <ul class="my-0">
                                <li>SEMESTER {{ strtoupper($item->semester) }}</li>
                                <li>{{ $item->tahun }}</li>
                                <li>Fase {{ $item->fase }}</li>
                            </ul>
                        </div>
                        <div class="card-footer">
                            @if (Auth::user()->identitas->posisi == "admin")
                            <div class="row">
                                @if ($item->ket == 0)
                                <div class="col-md-12">
                                    @php

                                        $detailraport = DB::connection("mysql")->table('detailraport')
                                        ->where("idraport", $item->idraport)
                                        ->where("iduser", $iduser)
                                        ->count()
                                    @endphp
                                    @if ($detailraport == 0)
                                        <button class="btn btn-primary btn-block mb-2" type="button" data-toggle="modal" data-target="#tambahdetailraport{{ $item->idraport }}">
                                            <b>KELOLA RAPORT</b>
                                        </button>
                                    @else
                                        <a href="{{ route('detailraport.view', [$item->idraport]) }}" class="btn btn-block btn-primary mb-2">
                                            <b>
                                                <i class="fa fa-eye"></i> KELOLA RAPORT
                                            </b>
                                        </a>
                                    @endif
                                    @if ($posisi=="admin" || $posisi=="walikelas")
                                        <a href="{{ url('cetakraport', [$item->idraport]) }}" class="btn btn-block btn-secondary mb-2">
                                            <b>
                                                <i class="fa fa-print"></i> CETAK RAPORT
                                            </b>
                                        </a>
                                    @endif

                                    @if ($posisi=="walikelas")
                                        <button class="btn btn-block btn-danger mb-2" type="button" data-toggle="modal" data-target="#legerguru{{ $item->idraport }}">
                                            <b>
                                                <i class="fa fa-print"></i> CETAK LEGER
                                            </b>
                                        </button>


                                    @endif

                                    @if ($posisi=="admin")
                                        <button class="btn btn-block btn-danger mb-2" type="button" data-toggle="modal" data-target="#leger{{ $item->idraport }}">
                                            <b>
                                                <i class="fa fa-print"></i> CETAK LEGER
                                            </b>
                                        </button>
                                    @endif
                                </div>




                                @endif
                                <div class="col-md-12">
                                    @php
                                        if ($item->ket == 0) {
                                            $bg= "bg-success";
                                            $tex = "TELAH DI BUKA";
                                        }else {
                                            $bg="bg-danger";
                                            $tex = "TELAH DI TUTUP";
                                        }
                                    @endphp
                                    @if ($user->identitas->posisi == "admin")
                                    <form action="{{ route('open.raport', [$item->idraport]) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn {{ $bg }} btn-block">
                                            <b>{{ $tex }}</b>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>



                            {{-- ------------------------------------- --}}
                            @else
                            @if (empty($item->idtarget))
                            <div class="row">
                                <div class="col-md-12">
                                    @php

                                        $detailraport = DB::table('detailraport')
                                        ->where("idraport", $item->idraport)
                                        ->where("iduser", $iduser)
                                        ->count()
                                    @endphp
                                    @if ($detailraport == 0)
                                        <button class="btn btn-primary btn-block mb-2" type="button" data-toggle="modal" data-target="#tambahdetailraport{{ $item->idraport }}">
                                            <b>KELOLA RAPORT</b>
                                        </button>
                                    @else
                                        <a href="{{ route('detailraport.view', [$item->idraport]) }}" class="btn btn-block btn-primary mb-2">
                                            <b>
                                                <i class="fa fa-eye"></i> KELOLA RAPORT
                                            </b>
                                        </a>
                                    @endif
                                    @if ($posisi=="admin" || $posisi=="walikelas")
                                        <a href="{{ url('cetakraport', [$item->idraport]) }}" class="btn btn-block btn-secondary mb-2">
                                            <b>
                                                <i class="fa fa-print"></i> CETAK RAPORT
                                            </b>
                                        </a>
                                    @endif

                                    @if ($posisi=="walikelas")
                                        <button class="btn btn-block btn-danger mb-2" type="button" data-toggle="modal" data-target="#legerguru{{ $item->idraport }}">
                                            <b>
                                                <i class="fa fa-print"></i> CETAK LEGER
                                            </b>
                                        </button>


                                    @endif

                                    @if ($posisi=="admin")
                                        <button class="btn btn-block btn-danger mb-2" type="button" data-toggle="modal" data-target="#leger{{ $item->idraport }}">
                                            <b>
                                                <i class="fa fa-print"></i> CETAK LEGER
                                            </b>
                                        </button>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    @php
                                        if ($item->ket == 0) {
                                            $bg= "bg-success";
                                            $tex = "TELAH DI BUKA";
                                        }else {
                                            $bg="bg-danger";
                                            $tex = "TELAH DI TUTUP";
                                        }
                                    @endphp
                                    @if ($user->identitas->posisi == "admin")
                                    <form action="{{ route('open.raport', [$item->idraport]) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn {{ $bg }} btn-block">
                                            <b>{{ $tex }}</b>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>


                            @else
                                @php
                                    $sinkron = DB::connection("mysql")->table("sinkron")->where("idraport", $item->idraport)->where("iduser", $iduser);
                                @endphp

                                @if ($sinkron->count()  > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        @php

                                            $detailraport = DB::table('detailraport')
                                            ->where("idraport", $item->idraport)
                                            ->where("iduser", $iduser)
                                            ->count()
                                        @endphp
                                        @if ($detailraport == 0)
                                            <button class="btn btn-primary btn-block mb-2" type="button" data-toggle="modal" data-target="#tambahdetailraport{{ $item->idraport }}">
                                                <b>KELOLA RAPORT</b>
                                            </button>
                                        @else
                                            <a href="{{ route('detailraport.view', [$item->idraport]) }}" class="btn btn-block btn-primary mb-2">
                                                <b>
                                                    <i class="fa fa-eye"></i> KELOLA RAPORT
                                                </b>
                                            </a>
                                        @endif
                                        @if ($posisi=="admin" || $posisi=="walikelas")
                                            <a href="{{ url('cetakraport', [$item->idraport]) }}" class="btn btn-block btn-secondary mb-2">
                                                <b>
                                                    <i class="fa fa-print"></i> CETAK RAPORT
                                                </b>
                                            </a>
                                        @endif

                                        @if ($posisi=="walikelas")
                                            <button class="btn btn-block btn-danger mb-2" type="button" data-toggle="modal" data-target="#legerguru{{ $item->idraport }}">
                                                <b>
                                                    <i class="fa fa-print"></i> CETAK LEGER
                                                </b>
                                            </button>


                                        @endif

                                        @if ($posisi=="admin")
                                            <button class="btn btn-block btn-danger mb-2" type="button" data-toggle="modal" data-target="#leger{{ $item->idraport }}">
                                                <b>
                                                    <i class="fa fa-print"></i> CETAK LEGER
                                                </b>
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        @php
                                            if ($item->ket == 0) {
                                                $bg= "bg-success";
                                                $tex = "TELAH DI BUKA";
                                            }else {
                                                $bg="bg-danger";
                                                $tex = "TELAH DI TUTUP";
                                            }
                                        @endphp
                                        @if ($user->identitas->posisi == "admin")
                                        <form action="{{ route('open.raport', [$item->idraport]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn {{ $bg }} btn-block">
                                                <b>{{ $tex }}</b>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                                @else
                                    <button class="btn btn-danger btn-block" type="button" data-toggle="modal" data-target="#prosessinkron{{ $item->idraport }}">SINKRONKAN DATA</button>


                                    <div id="prosessinkron{{ $item->idraport }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="my-modal-title">PERHATIAN</h5>
                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Dengan menekan <b>Sinkronkan Data Sekarang</b>, maka penilaian pada raport UTS {{ $item->semester }} akan di tarik ke raport semester {{ $item->semester }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('sinkron.raport', [$item->idraport]) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-block btn-success">SINKONKAN DATA SEKARANG</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                @endif

                            @endif



                            @endif

                            @if ($pembinaex > 0)
                                <a href="{{ route('extrakulikuler.open', [$item->idraport]) }}" class="btn btn-warning btn-block text-bold">
                                    KELOLA EXTRAKULIKULER
                                </a>
                            @endif



                        </div>
                    </div>
                </div>


            @endforeach

        </div>
   </div>

   @foreach ($raport as $item)

   <div id="legerguru{{ $item->idraport }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">CETAK LEGER</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('leger.raport', [$item->idraport]) }}" method="get" target="_blank">
                @csrf
                @method("GET")
                <div class="modal-body">
                    <div class="form-group">
                        <label for="opsi">Pilih Opsi</label>
                        <select id="opsi" class="form-control" name="opsi">
                            <option value="urut">Diurutkan berdasarkan ranking</option>
                            <option value="acak">Berdasarkan Abjad Nama (A-Z)</option>
                        </select>
                    </div>


                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-success">
                        Cetak Leger
                    </button>
                </div>

            </form>
        </div>
    </div>
   </div>

   <div id="leger{{ $item->idraport }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">CETAK LEGER</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('leger.raport', [$item->idraport]) }}" method="get" target="_blank">
                @csrf
                @method("GET")
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select id="kelas" class="form-control" name="idkelas">
                            @foreach ($kelas as $k)
                            <option value="{{ $k->idkelas }}">{{ $k->namakelas }}</option>

                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jurusan">jurusan</label>
                        <select id="jurusan" class="form-control" name="idjurusan">
                            <option value="all">Semua Jurusan</option>
                            @foreach ($jurusan as $k)
                            <option value="{{ $k->idjurusan }}">{{ $k->namajurusan }}</option>

                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-success">
                        Cetak Leger
                    </button>
                </div>

            </form>
        </div>
    </div>
   </div>




   <div id="tambahdetailraport{{ $item->idraport }}" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase" id="my-modal-title">TAMBAH {{ $item->namaraport }}</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tambah.detailraport', [$item->idraport]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Guru</label>
                        <input id="name" class="form-control" value="{{ $user->name }}" type="text" name="name" disabled>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <select required name="idkelas" class="form-control select2kelas{{ $loop->iteration }}" style="width: 100%;">
                            <option selected disabled><b>PILIH KELAS</b></option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->idkelas }}">{{ $k->namakelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mata Pelajaran</label>
                        <select required name="idmapel" class="form-control select2mapel{{ $loop->iteration }}" style="width: 100%;">
                            <option selected disabled><b>PILIH MAPEL</b></option>
                            @foreach ($mapel as $m)
                                <option value="{{ $m->idmapel }}">{{ $m->namamapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mata Pelajaran</label>
                        <select required name="idjurusan" class="form-control select2jurusan{{ $loop->iteration }}" style="width: 100%;">
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
   @endforeach

@endsection

@section('script')
@foreach ($raport as $item)
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

@endforeach
@endsection
