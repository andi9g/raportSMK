@extends('layouts.master')

@section('warnaraport', 'active')
@section('judul', 'Data Extrakulikuler')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover table-striped table-bordered table-lg">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Extrakulikuler</th>
                            <th>Kelola</th>
                        </tr>
                    </thead>
        
                    <tbody>
                        @foreach ($pembinaex as $item)
                            <tr>
                                <td width="5px" class="text-lg">{{ $loop->iteration }}</td>
                                <td class="text-bold text-lg">{{ strtoupper($item->namaex) }}</td>
                                <td>
                                    <a href="{{ route('extrakulikuler.kelola', [$idraport, $item->idpembinaex]) }}" class="btn btn-success btn-block">
                                        KELOLA NILAI
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection