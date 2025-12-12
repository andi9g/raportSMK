@extends('layouts.master')

@section('warnaraportp5', 'active')

@section("judul", "PENIALAIAN RAPORT P5")

@section('content')
<div id="ubahproject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Ubah Project Penilaian</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('ubah.project.p5', [$idraportp5]) }}" method="post">
                @csrf
                @method("PUT")
                @if (request("koordinator")=="true")
                    @php
                        $identitasp5 = App\Models\identitasp5M::where("iduser", Auth::user()->iduser)->get();
                        // dd($identitasp5)
                    @endphp
                    <input type="hidden" name="koordinator" value="true">
                    @foreach ($identitasp5 as $item)
                    @php
                        $tema = App\Models\judulp5M::where("iduser", $item->iduser)
                        ->where("idkelas", $item->idkelas)
                        ->where("idraportp5", $idraportp5)
                        ->where("idjurusan", $item->idjurusan)->first()->judulp5??"";
                    @endphp
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaproject">Tema {{ $item->kelas->namakelas." ".$item->jurusan->jurusan }}</label>
                            <input id="namaproject" class="form-control" type="text" name="judulp5{{ $item->ididentitasp5 }}" value="{{ $tema }}">
                        </div>
                    </div>
                    @endforeach

                    @else
                    <input type="hidden" name="koordinator" value="false">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaproject">Nama Project</label>
                            <input id="namaproject" class="form-control" type="text" name="judulp5" value="{{ empty($project->judulp5)?'':$project->judulp5 }}">
                        </div>
                    </div>

                @endif

                

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Ubah Project
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
                <div class="col-md-8">
                    @if (request("koordinator")==true)
                        @php
                            $identitasp5 = App\Models\identitasp5M::where("iduser", Auth::user()->iduser)->get();
                            // dd($identitasp5)
                        @endphp
                        @foreach ($identitasp5 as $item)
                        @php
                            $tema = App\Models\judulp5M::where("iduser", $item->iduser)
                            ->where("idkelas", $item->idkelas)
                            ->where("idraportp5", $idraportp5)
                            ->where("idjurusan", $item->idjurusan)->first()->judulp5??"Belum memiliki nama kegiatan";
                        @endphp
                        <h5 class="text-uppercase text-bold w-100 mb-0 p-0 d-inline">
                                "{{ "Kelas ".$item->kelas->namakelas." ".$item->jurusan->jurusan." : ".$tema }}"
                        </h5><br>
                        @endforeach

                    @else
                        <h4 class="text-uppercase text-bold w-100 mb-0 p-0 d-inline">
                            <u>
                                {{ empty($project->judulp5)?"Belum memiliki nama kegiatan":$project->judulp5 }}
                            </u>
                        </h4>
                    @endif

                    &emsp;


                    <button class="badge py-1 border-0 badge-primary d-inline px-5 py-2" type="button" data-toggle="modal" data-target="#ubahproject">
                        <i class="fa fa-edit"></i> Ubah
                    </button>
                </div>
                <div class="col-md-4">
                    <form action="{{ url()->current() }}">
                        @csrf
                        <div class="input-group">
                            <input class="form-control" type="text" name="keyword" placeholder="keyword" aria-label="keyword" value="{{ $keyword }}" aria-describedby="keyword">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text" id="keyword">
                                    <i class="fa fa-search"></i>Cari
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="page" value="{{ request('page') }}">

                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <div class="row my-2">
                    <div class="col-6">
                        @if (request("koordinator")==true)
                            <a href="{{ url()->current() }}" class="btn btn-danger">SEBAGAI WALIKELAS</a>

                            @else
                            <form action="{{ url()->current() }}" method="get">
                                <button type="submit" class="btn btn-success" value="true" name="koordinator">SEBAGAI KOORDINATOR</button>
                                <input type="hidden" name="page" value="{{ request('page') }}">
                            </form>
                        @endif
                    </div>
                    <div class="col-6">
                        <h5 class="text-right text-uppercase text-primary"><b>{{ $raportp5->tema }}</b></h5>
                    </div>
                </div>
                <table class="table table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Rombel</th>
                            <th>Ket</th>
                            <th>Nilai</th>
                            @if (!empty(Auth::user()->identitas->walikelas))
                                <th>Cetak</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $item)
                        <tr>
                            <td width="5px" align="center">{{ $loop->iteration + $siswa->firstItem() - 1 }}</td>
                            <td width="5px" class="text-bold">{{ sprintf("%010s",$item->nisn) }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kelas->namakelas." ".$item->jurusan->jurusan }}</td>

                            <td width="8px">
                                @php
                                    $cek = \App\Models\penilaianp5M::where("idraportp5", $idraportp5)->where("nisn", sprintf("%010s", $item->nisn))->count();

                                @endphp
                                @if ($totalHitung == $cek)
                                    <small class="badge badge-success">Telah Dinilai</small>
                                @elseif($cek == 0)
                                    <small class="badge badge-danger">Belum Dinilai</small>
                                @else
                                    <small class="badge badge-secondary">
                                        {{ $cek." dari ".$totalHitung }}

                                    </small>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('nilai.raport.p5', [$idraportp5,$item->nisn, $pages]) }}" class="btn btn-success btn-block btn-sm rounded-0 text-bold">NILAI</a>
                            </td>
                            @php
                                $akun = Auth::user();
                            @endphp
                            <td>
                                @if ($akun->identitas->walikelas->idkelas??"" == $item->idkelas)
                                    <a href="{{ route('cetak.raport.p5', [$idraportp5,$item->nisn, $pages]) }}" target="_blank" class="btn btn-secondary btn-block btn-sm">
                                        <i class="fa fa-print"></i> CETAK
                                    </a>
                                @else
                                    Bukan Walikelas
                                @endif
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="card-footer">
            {{ $siswa->links("vendor.pagination.bootstrap-4") }}
        </div>
    </div>
</div>


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
