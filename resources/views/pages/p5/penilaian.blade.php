@extends('layouts.master')

@section('warnaraportp5', 'active')

@section("judul", "NILAI RAPOR P5")

@section('header')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

<div class="container">
    <a href="{{ url('raportp5', [$idraportp5]) }}" class="btn btn-danger btn-sm my-0 rounded-0">Kembali Halaman Sebelumnya</a>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase text-bold">PROFILE</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-striped">
                        <tr>
                            <td width="5px" nowrap>NAMA LENGKAP</td>
                            <td width="">:</td>
                            <td class="text-bold">{{ $siswa->nama }}</td>
                        </tr>
                        <tr>
                            <td width="5px" nowrap>ROMBEL</td>
                            <td width="5px">:</td>
                            <td class="text-bold">{{ $siswa->kelas->namakelas." ".$siswa->jurusan->jurusan }}</td>
                        </tr>
                        <tr>
                            <td width="5px" nowrap>Alamat</td>
                            <td width="5px">:</td>
                            <td class="text-bold" valign="top">{{ $siswa->alamat }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Keterangan</h5><br>
                    <ul>
                    @foreach ($keteranganp5 as $keterangan)
                        <li class="text-bold">{{$keterangan->inisialp5}}</li>
                        {{ $keterangan->deskripsi }}
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase text-bold">PENILAIAN</h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            @foreach ($temap5 as $tema)
                            <tr>
                                <th class="text-bold">Project {{ $loop->iteration }} | Tema : {{ $tema->temap5 }}</th>
                                @foreach ($keteranganp5 as $keterangan)
                                    <th class="text-center">{{ strtoupper($keterangan->inisialp5) }}</th>
                                @endforeach
                            </tr>

                            @php
                                $dimensip5 = $tema->dimensip5->get();
                            @endphp

                            @foreach ($dimensip5 as $dimensi)
                                <tr>
                                    <td class="text-bold" style="background: rgba(60, 255, 21, 0.144)" colspan="{{ count($keteranganp5) + 1 }}">
                                        {{ $dimensi->dimensip5 }}
                                    </td>
                                </tr>

                                @php
                                    $subdimensip5 = $dimensi->subdimensip5->where("iddimensip5", $dimensi->iddimensip5)->get();
                                @endphp
                                @foreach ($subdimensip5 as $subdimensi)
                                    <tr>
                                        <td>
                                            <ul>
                                                <li class="text-bold">{{ $subdimensi->subdimensip5 }}</li>
                                                {{ $subdimensi->deskripsi }}
                                            </ul>
                                        </td>
                                        @foreach ($keteranganp5 as $keterangan)
                                            <td class="text-center">
                                                @php
                                                    $checked = DB::connection("mysql")
                                                    ->table("penilaianp5")
                                                    ->where("idketeranganp5", $keterangan->idketeranganp5)
                                                    ->where("nisn", $siswa->nisn)
                                                    ->where("idraportp5", $idraportp5)
                                                    ->where("idsubdimensip5", $subdimensi->idsubdimensip5)->count();
                                                @endphp
                                                <input type="radio" onchange="kirimpost({{ $nisn }}, {{ $keterangan->idketeranganp5 }}, {{ $subdimensi->idsubdimensip5 }}, {{ $idraportp5 }})" name="nilai{{ $subdimensi->idsubdimensip5 }}" value="{{ $subdimensi->idsubdimensip5 }}" id="" @if ($checked == 1)
                                                    checked 
                                                @endif>
                                            </td>
                                    @endforeach
                                    </tr>
                                    
                                @endforeach

                            @endforeach
                                
                            @endforeach
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    <a href="{{ url('raportp5', [$idraportp5]) }}" class="btn btn-danger btn-block my-0 rounded-0">Kembali Halaman Sebelumnya</a>
                </div>

            </div>
        </div>
    </div>
</div>



@endsection





@section('script')
<script>
    // Set CSRF token pada setiap permintaan Ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function kirimpost(nisn, idketerangan, idsubdimensi, idraport) {

        $.ajax({
            type: 'POST',
            url: "{{ route('kirim.nilai.p5', ['nisn' => ':nisn', 'idketeranganp5' => ':idketeranganp5']) }}"
                .replace(':nisn', nisn)
                .replace(':idketeranganp5', idketerangan),
            data: {
                idsubdimensip5: idsubdimensi,
                idraportp5: idraport
            },
            success: function(data) {
                if(data.success != "berhasil") {
                    alert(data.success);
                }else {
                    alert(data.success);
                }
            }
        });
    }
</script>
@endsection

