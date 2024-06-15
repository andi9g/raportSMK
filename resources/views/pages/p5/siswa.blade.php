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
                <div class="modal-body">
                    <div class="form-group">
                        <label for="namaproject">Nama Project</label>
                        <input id="namaproject" class="form-control" type="text" name="namaproject" value="{{ $project }}">
                    </div>
                </div>
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
                    <h4 class="text-uppercase text-bold w-100 mb-0 p-0 d-inline">
                        <u>
                            "{{ $project }}"
                        </u>
                    </h4>
                    &emsp;
                    <button class="badge py-1 border-0 badge-primary d-inline" type="button" data-toggle="modal" data-target="#ubahproject">
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

                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Rombel</th>
                            <th>Ket</th>
                            <th>Nilai</th>
                            <th>Cetak</th>
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
                                <a href="{{ route('nilai.raport.p5', [$idraportp5,$item->nisn]) }}" class="btn btn-success btn-block btn-sm rounded-0 text-bold">NILAI</a>
                            </td>
                            <td>
                                <a href="{{ route('cetak.raport.p5', [$idraportp5,$item->nisn]) }}" target="_blank" class="btn btn-secondary btn-block btn-sm">
                                    <i class="fa fa-print"></i> CETAK
                                </a>
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
