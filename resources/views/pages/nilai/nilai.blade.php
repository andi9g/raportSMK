@extends('layouts.master')

@section('warnaraport', 'active')

@section("judul")
    {{ strtoupper($judul) }}
@endsection

@section("judul2")
    <b>
        {{ strtoupper($mapel) }}
    </b>
@endsection
@section('content')



<div class="container">
    <a href="{{ route('detailraport.view', [$idraport]) }}" class="btn btn-danger btn-sm my-0 rounded-0">Halaman Sebelumnya</a>
    <div class="row">

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-2">TARGET PEMBELAJARAN (TP)</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary btn-md px-5 my-0 btn-block text-bold" type="button" data-toggle="modal" data-target="#tambahelemen">TAMBAH TP</button>
                    <hr>

                    @foreach ($elemen as $item)
                    <div class="row bg-light">
                        <div class="col-12">
                            <table width="100%">
                                <tr>
                                    <td width="80%">
                                        <ul>
                                            <li class="mb-2">{{ $item->elemen }}</li>
                                        </ul>
                                    </td>
                                    <td valign="top" nowrap>
                                        <button class="badge badge-info d-inline px-2 py-1 border-0" type="button" data-toggle="modal" data-target="#editelemen{{ $item->idelemen }}">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <form action="{{ route('elemen.hapus', [$item->idelemen]) }}" method="post" class="d-inline">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="badge badge-danger border-0 py-1 px-1" onclick="return confirm('Yakin ingin menghapus elemen?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
            
                                        </form>

                                        
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div id="editelemen{{ $item->idelemen }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="my-modal-title">Edit Data</h5>
                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('elemen.edit', [$item->idelemen]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="elemen">Target Pembelajaran</label>
                                            <textarea name="elemen" class="form-control" id="" rows="3" placeholder="contoh :menggeneralisasi sifat-sifat bilangan berpangkat (termasuk bilangan pangkat pecahan)">{{ $item->elemen }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer text-right">
                                        <button type="submit" class="btn btn-success">Ubah Target Pembelajaran</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    
                    
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mt-0">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <button class="btn btn-primary mb-2 px-4" type="button" data-toggle="modal" data-target="#cetak">
                                <b>Cetak Data</b>
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
        
                
                <div class="card-body mt-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered m-0 table-sm">
                            <thead>
                                <th width="5px">No</th>
                                <th>Nama Siswa</th>
                                <th>Rombel</th>
                                <th>Catatan</th>
                                <th>Nilai</th>
                                <th>Ujian</th>
                                <th>Catatan</th>
                            </thead>
            
                            <tbody>
                                @foreach ($siswa as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-bold">{{ strtoupper($item->nama) }}</td>
                                    <td>{{ $item->kelas->namakelas." ".$item->jurusan->jurusan }}</td>
                                    
                                    <td class="text-center">
                                        @php
                                            $catatan = DB::table("catatan")->where("idsiswa", $item->idsiswa)
                                            ->where("iddetailraport", $iddetailraport)->count();
                                        @endphp
                                        @if ($catatan == null)
                                            -
                                        @else
                                            <font class="text-success text-bold">
                                                <i class="fa fa-check"></i>
                                            </font>
                                        @endif
                                    </td>
                                    @php
                                        $nilaisiswa = DB::table("nilairaport")->join("elemen", "elemen.idelemen", "nilairaport.idelemen")->where("nilairaport.idsiswa", $item->idsiswa)->where("nilairaport.iddetailraport", $iddetailraport)->count();
                                        
                                        $ujian = DB::table("ujian")->where("idsiswa", $item->idsiswa)
                                        ->where("idraport", $idraport)
                                        ->where("idmapel", $idmapel)
                                        ->count();
                                    @endphp
                                    @if ($ujian==0)
                                        @php
                                            $warnanilai2 = "bg-danger";
                                        @endphp    
                                    @else
                                        @php
                                            $warnanilai2 = "bg-success";
                                        @endphp  
                                    @endif
    
                                    @if(count($jmlelemen) == $nilaisiswa) 
                                        @if (count($jmlelemen) == 0)
                                        @php
                                            $warnanilai1 = "bg-danger";
                                        @endphp
                                        @else 
                                            @php
                                                $warnanilai1 = "bg-success";
                                            @endphp
                                        @endif
                                    @else 
                                    @php
                                        $warnanilai1 = "bg-danger";
                                    @endphp
                                    @endif
                                    <td>
                                        <button class="btn {{ $warnanilai1 }} btn-block btn-xs my-0" type="button" data-toggle="modal" data-target="#nilairaport{{ $item->idsiswa }}"><b>PENILAIAN</b></button>
                                    </td>
                                    <td>
                                        <button class="btn {{ $warnanilai2 }} btn-block btn-xs my-0" type="button" data-toggle="modal" data-target="#ujian{{ $item->idsiswa }}"><b>UJIAN</b></button>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-xs my-0" type="button" data-toggle="modal" data-target="#catatan{{ $item->idsiswa }}"><b>CATATAN</b></button>
                                    </td>
    
                                </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
    </div>

</div>





<div id="tambahelemen" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tambahelemen" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahelemen">Tambah Elemen</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('elemen.tambah', [$iddetailraport]) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="elemen">Target Pembelajaran</label>
                            <textarea name="elemen" class="form-control" id="" rows="3" placeholder="contoh :menggeneralisasi sifat-sifat bilangan berpangkat (termasuk bilangan pangkat pecahan)"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Tambah Elemen</button>
                </div>
            </form>
        </div>
    </div>
</div>



@foreach ($siswa as $item)

    <div id="ujian{{ $item->idsiswa }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ujian{{ $item->idsiswa }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ujian{{ $item->idsiswa }}">Masukan Nilai Ujian</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('nilai.ujian', [$idraport]) }}" method="post">
                    @csrf
                
                <div class="modal-body">
                    <p class="text-md">

                        <font class="text-danger">Masukan nilai ujian <b>Lisan</b> ataupun <b>Nonlisan</b>, jika tidak ada beri nilai <b>0</b></font>
                    </p>
                    @php
                        $ujian = DB::table("ujian")->where("idsiswa", $item->idsiswa)
                        ->where("idraport", $idraport)
                        ->where("idmapel", $idmapel)
                        ->first();
                    @endphp
                    <input type="text" name="idsiswa" value="{{ $item->idsiswa }}" hidden>
                    <input type="text" name="idmapel" value="{{ $idmapel }}" hidden>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input id="nama" class="form-control" type="text" disabled value="{{ $item->nama }}">
                    </div>

                    <div class="form-group">
                        <label for="ujianlisan">Nilai Ujian Lisan</label>
                        <input id="ujianlisan" class="form-control" onchange="changeHandler(this)" onkeyup="changeHandler(this)" type="number" name="lisan" value="{{ empty($ujian->lisan)?0:$ujian->lisan }}">
                    </div>

                    <div class="form-group">
                        <label for="ujianlisan">Nilai Ujian Non-Lisan</label>
                        <input id="ujianlisan" class="form-control" type="number" onchange="changeHandler(this)" onkeyup="changeHandler(this)" name="nonlisan" value="{{ empty($ujian->lisan)?0:$ujian->nonlisan }}">
                    </div>
                    
                    
                </div>
                <div class="modal-footer text-right">
                    <button type="submit" class="btn btn-success px-4">
                        <b>
                            PROSESS
                        </b>
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div id="nilairaport{{ $item->idsiswa }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">PENILAIAN <b>{{ strtoupper($item->nama) }}</b></h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('nilai.siswa', [$iddetailraport]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="text" name="idsiswa" value="{{ $item->idsiswa }}" hidden>
    
                        @foreach ($elemen as $e)
                            @php
                                $datanilai = DB::table("nilairaport")->where("idelemen", $e->idelemen)
                                ->where("idsiswa", $item->idsiswa)
                                ->where("iddetailraport", $iddetailraport)
                                ->select("nilai")
                                ->first();
                                $nilai = empty($datanilai->nilai)?"":$datanilai->nilai;
                            @endphp

                            <div class="form-group text-md">
                                <label for="inputan{{ $e->idelemen }}" style="font-weight: normal"><i>{{ $e->elemen }}</i></label>
                                <input id="inputan{{ $e->idelemen }}" class="form-control" type="number" onchange="changeHandler(this)" onkeyup="changeHandler(this)" name="elemen{{ $e->idelemen }}" placeholder="masukan nilai" value="{{$nilai}}">
                            </div>
    
                            
                        @endforeach
    
                    </div>
                    <div class="modal-footer text-right">
                        <button type="submit" class="btn btn-success px-4">
                            <b>
                                BERI NILAI 
                            </b>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="catatan{{ $item->idsiswa }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Catatan Untuk Siswa</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tambah.catatan', [$iddetailraport]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="number" value="{{ $item->idsiswa }}" name="idsiswa" hidden>
                        <div class="form-group">
                            <label for="nama">Nama Siswa</label>
                            <input id="nama" class="form-control" type="text" disabled value="{{ $item->nama }}">
                        </div>

                        @php
                            $catatan = DB::table("catatan")->where("idsiswa", $item->idsiswa)
                            ->where("iddetailraport", $iddetailraport)->first();
                        @endphp
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <textarea id="catatan" class="form-control" name="catatan" rows="3">{{ empty($catatan->catatan)?"":$catatan->catatan }}</textarea>
                        </div>

                        <p class="text-danger"><i>Catatan bagi siswa untuk meningkatkan kompetensi tertentu</i></p>
                    </div>
                    <div class="modal-footer text-right">
                        <button type="submit" class="btn btn-success">INPUT CATATAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endforeach

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

        function changeHandler(val)
        {
            if (Number(val.value) > 100)
            {
                val.value = 100
            }
        }
    </script>
@endsection