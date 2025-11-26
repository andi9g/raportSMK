@extends('layouts.master')

@section('warnaraportpkl', 'active')

@section("judul", "Data Raport PKL")
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#tambahpkl">
              Tambah PKL
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="tambahpkl" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah PKL</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <form action="{{ route('raporpkl.store', []) }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class='form-group'>
                                    <label for='forkelas' class='text-capitalize'>Kelas</label>
                                    <select name='idkelas' id='forkelas' class='form-control'>
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->idkelas }}" @if ($item->namakelas == "XII")
                                                selected
                                            @endif>{{ $item->namakelas }}</option>
                                        @endforeach
                                    <select>
                                </div>
        
                                <div class="form-group">
                                    <label for="tahunajaran">Tahun</label>
                                    <select id="tahunajaran" class="form-control" name="tahunajaran" sele>
                                        @php
                                            $tahun = ((int) date('Y')) - 3;
                                            $sekarang = ((int) date('Y'));
                                        @endphp
                                        @for ($i = $tahun; $i <= ((int) date('Y')); $i++)
                                            <option value="{{ $i }}/{{ $i+1 }}" @if ($i == date("Y"))
                                                selected
                                            @endif>{{ $i }}/{{ $i+1 }}</option>
        
                                        @endfor
                                    </select>
                                </div>

                                <div class='form-group'>
                                    <label for='fortanggalmulai' class='text-capitalize'>Tanggal Mulai</label>
                                    <input type='date' name='tanggalmulai' id='fortanggalmulai' class='form-control' placeholder='masukan namaplaceholder'>
                                </div>

                                <div class='form-group'>
                                    <label for='fortanggalselesai' class='text-capitalize'>Tanggal Selesai</label>
                                    <input type='date' name='tanggalselesai' id='fortanggalselesai' class='form-control' placeholder='masukan namaplaceholder'>
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
        </div>
    </div>

    @foreach ($raport as $item)
        
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title text-capitalize text-bold">PRAKTEK KERJA LAPANGAN</h5>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-lg">TP.{{ $item->tahunajaran }}</li>
            <li class="list-group-item text-lg">Kelas {{ $item->kelas->namakelas }}</li>
            <li class="list-group-item text-lg @if ($item->status == 1)
                text-success
                @else
                text-danger
            @endif">@if ($item->status == 1)
                DIBUKA
                @else
                DITUTUP
            @endif
        </li>
        </ul>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <a href="{{ route('pesertapkl.index', [$item->idpkl]) }}" class="btn btn-success btn-block">CEK PESERTA</a>
                </div>
                @if (Auth::user()->username == "admin")
                <div class="col">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#edit{{ $item->idpkl }}">
                      Edit
                    </button>
                </div>
                    
                @endif
            </div>
            @if (Auth::user()->username == "admin")
            <div class="row">
                <div class="col">
                    <a href="{{ route('ttd.pkl', [$item->idpkl]) }}" class="btn btn-secondary btn-block my-2">TTD PKL</a>
                </div>
            </div>
            @endif
        </div>
    </div>
    

    <div class="modal fade" id="edit{{ $item->idpkl }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">EDIT RAPOR PKL</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form action="{{ route('raporpkl.update', [$item->idpkl]) }}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="modal-body">
                        
                        <div class='form-group'>
                            <label for='forkelas' class='text-capitalize'>Kelas</label>
                            <select name='idkelas' id='forkelas' class='form-control'>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->idkelas }}" @if ($k->namakelas == "XII")
                                        selected
                                    @endif>{{ $k->namakelas }}</option>
                                @endforeach
                            <select>
                        </div>

                        
                        <div class="form-group">
                            <label for="tahunajaran">Tahun</label>
                            <select id="tahunajaran" class="form-control" name="tahunajaran" sele>
                                @php
                                    $tahun = ((int) date('Y')) - 3;
                                    $sekarang = ((int) date('Y'));
                                @endphp
                                @for ($i = $tahun; $i <= ((int) date('Y')); $i++)
                                    <option value="{{ $i }}/{{ $i+1 }}" @if ($i == date("Y"))
                                        selected
                                    @endif>{{ $i }}/{{ $i+1 }}</option>

                                @endfor
                            </select>
                        </div>

                        <div class='form-group'>
                            <label for='fortanggalmulai' class='text-capitalize'>Tanggal Mulai</label>
                            <input type='date' name='tanggalmulai' id='fortanggalmulai' value="{!! $item->tanggalmulai !!}" class='form-control' placeholder='masukan namaplaceholder'>
                        </div>

                        <div class='form-group'>
                            <label for='fortanggalselesai' class='text-capitalize'>Tanggal Selesai</label>
                            <input type='date' name='tanggalselesai' id='fortanggalselesai' value="{!! $item->tanggalselesai !!}" class='form-control' placeholder='masukan namaplaceholder'>
                        </div>

                        
                        <div class='form-group'>
                            <label for='forstatus' class='text-capitalize'>Status</label>
                            <select name='status' id='forstatus' class='form-control'>
                                <option value="0" @if ($item->status == 0)
                                    selected
                                @endif>DI TUTUP</option>
                                <option value="1" @if ($item->status == 1)
                                    selected
                                @endif>DI BUKA</option>
                                
                                
                            <select>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endforeach

</div>




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
