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
                    <table class="table table-striped table-hover table-bordered m-0 table-sm">
                        <thead>
                            <th width="5px">No</th>
                            <th>Nama Siswa</th>
                            <th>Rombel</th>
                            <th>Ket</th>
                            <th>Nilai</th>
                            <th>Data Nilai</th>
                        </thead>
        
                        <tbody>
                            @foreach ($siswa as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-bold">{{ strtoupper($item->nama) }}</td>
                                <td>{{ $item->kelas->namakelas." ".$item->jurusan->jurusan }}</td>
                                <td>
                                    @php
                                        $nilaisiswa = DB::table("nilairaport")->where("idsiswa", $item->idsiswa)->where("iddetailraport", $iddetailraport)->count();
                                        
                                    @endphp
                                    @if(count($jmlelemen) == $nilaisiswa) 
                                        <font class="text-success text-bold">OKE</font>
                                    @else 
                                        -
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-success btn-block btn-xs my-0" type="button" data-toggle="modal" data-target="#nilairaport{{ $item->idsiswa }}"><b>KELOLA NILAI</b></button>
                                </td>
                                <td>
                                    <a href="" class="btn btn-secondary btn-block btn-xs my-0"><b>
                                        <i class="fa fa-print"></i> CETAK   
                                    </b></a>
                                </td>
                            </tr>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                                <input id="inputan{{ $e->idelemen }}" class="form-control" type="number" name="elemen{{ $e->idelemen }}" placeholder="masukan nilai" value="{{$nilai}}">
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
    </script>
@endsection