@extends('layouts.master')

@section('kenaikankelasActive', 'active')
@section('judul', 'Kenaikan Kelas')


@section('content')

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="my-0 card-title">Form Kenaikan Kelas</h3>
                </div>
                <form action="{{ route('kenaikankelas.store', []) }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class='form-group'>
                            <label for='forkelas' class='text-capitalize'>Kelas</label>
                            <select name='kelas' id='forkelas' class='form-control' required>
                                <option value=''>Pilih</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->idkelas }}">{{ $item->namakelas }}</option>
                                @endforeach

                            <select>
                        </div>
                        <div class='form-group'>
                            <label for='fornaikkelas' class='text-capitalize'>naik ke kelas</label>
                            <select name='naikkelas' id='fornaikkelas' class='form-control' required>
                                <option value=''>Pilih</option>
                                @foreach ($kelas as $item)
                                    <option value="{{ $item->idkelas }}">{{ $item->namakelas }}</option>
                                @endforeach

                            <select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Yakin ingin dinaikan?')">Naik Kelas</button>
                    </div>

                </form>
            </div>

        </div>
    </div>


@endsection
