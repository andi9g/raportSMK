@extends('layouts.master')

@section('warnaraport', 'active')
@section('judul', 'Data Extrakulikuler')


@section('header')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <div class="container">
    <a href="{{ url('extrakulikuler', [$idraport]) }}" class="btn btn-danger btn-sm my-0 rounded-0">Kembali Halaman Sebelumnya</a>
    <div class="card">
        <div class="card-header pb-0">
            <form action="{{ url()->current() }}" class="mb-0">
                <div class="row">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select id="jurusan" class="form-control" onchange="submit()" name="idjurusan">
                                        <option value="">Semua Jurusan</option>
                                        @foreach ($jurusan as $item)
                                            <option value="{{ $item->idjurusan }}" @if ($idjurusan == $item->idjurusan)
                                                selected
                                            @endif>{{ $item->jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select id="kelas" class="form-control" onchange="submit()" name="idkelas">
                                        <option value="">Semua Kelas</option>
                                        @foreach ($kelas as $item)
                                            <option value="{{ $item->idkelas }}" @if ($idkelas == $item->idkelas)
                                                selected
                                            @endif>{{ $item->namakelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input class="form-control" type="text" name="keyword" placeholder="keyword" aria-label="keyword" value="{{ $keyword }}" aria-describedby="keyword">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text" id="keyword">
                                    <i class="fa fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            
            </form>
        </div>

        <div class="card-body">
            <table class="table table-striped table-hover table-bordered table-sm">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Rombel</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $item)
                        <tr>
                            <td width="5px" align="center">{{ $loop->iteration + $siswa->firstItem() - 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kelas->namakelas." ".$item->jurusan->jurusan }}</td>
                            <td>
                                @php
                                    $pen = DB::connection("mysql")->table("penilaianex")
                                    ->where("idsiswa", $item->idsiswa)
                                    ->where("idpembinaex", $idpembinaex)
                                    ->where("idraport", $idraport);
                                @endphp
                               <div class="form-group mb-0">
                                <select id="nilai"  required class="form-control form-control-sm d-inline" name="nilai" onchange="kirimpost(this.value, {{ $item->idsiswa }}, {{ $idpembinaex }}, {{ $idraport }})">
                                    <option value="none">None</option>
                                    <option value="A" @if (empty($pen->first()->nilai)?"":$pen->first()->nilai == "A")
                                        selected
                                    @endif>A</option>
                                    <option value="B" @if (empty($pen->first()->nilai)?"":$pen->first()->nilai == "B")
                                        selected
                                    @endif>B</option>
                                    <option value="C" @if (empty($pen->first()->nilai)?"":$pen->first()->nilai == "C")
                                        selected
                                    @endif>C</option>
                                    <option value="D @if (empty($pen->first()->nilai)?"":$pen->first()->nilai == "D")
                                        selected
                                    @endif" >D</option>
                                </select>

                                
                               </div>
                               
                            </td>
                            <td width="5px">
                                @if ($pen->count()==1)
                                    <form action="{{ route('hapus.extrakulikuler', [$pen->first()->idpenilaianex]) }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" onclick="return confirm('yakin ingin dihapus?')" class="badge badge-danger d-inline py-1 border-0">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                                
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

        <div class="card-footer">
            {{ $siswa->links("vendor.pagination.bootstrap-4") }}
        </div>
    </div>
        
    </div>

@endsection


@section('script')
<script>
    // Set CSRF token pada setiap permintaan Ajax
    

    function kirimpost(nilai, idsiswaex, idpembina, idraport) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: "{{ route('extrakulikuler.kirim.nilai', ['idsiswa' => ':idsiswa']) }}"
                .replace(':idsiswa', idsiswaex),
            data: {
                nilai: nilai,
                idpembinaex: idpembina,
                idraport: idraport
            },
            success: function(data) {
                Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.message,
                });
            }
        });
    }
</script>