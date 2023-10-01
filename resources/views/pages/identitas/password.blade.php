@extends('layouts.master')

@section('warnaidentitas', 'active')
@section('judul', 'Identitas Diri')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card card-outline card-secondary">
                    <div class="card-header">
                        <h3 class="my-0 text-bold text-center">Ubah Password</h3>
                    </div>
                    <form action="{{ route('password.ubah', []) }}" method="post">
                        @csrf
                    
                        <div class="card-body">
                            <div class="form-group">
                                <label for="passwordlama">Password Lama</label>
                                <input id="passwordlama" class="form-control @error('passwordlama')
                                    is-invalid
                                @enderror" type="password" name="passwordlama" placeholder="password lama" value="{{  old('passwordlama') }}">

                            </div>
                            <div class="form-group">
                                <label for="password">Password Baru</label>
                                <input id="password" class="form-control @error('password')
                                    is-invalid
                                @enderror" type="password" name="password" placeholder="password lama" value="">

                            </div>
                            <div class="form-group">
                                <label for="password2">Ulangi Password Baru</label>
                                <input id="password2" class="form-control @error('password2')
                                    is-invalid
                                @enderror" type="password" name="password2" placeholder="password lama" value="">

                            </div>
                            
                        </div>
                        <div class="card-footer text-right">
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-success px-3">
                                <b>Ubah Password</b>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection