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
                        <h3 class="my-0 text-bold text-center">IDENTITAS</h3>
                    </div>
                    <form action="{{ route('identitas.store', []) }}" method="post">
                        @csrf
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" type="text">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input id="username" name="username" class="form-control" value="{{ Auth::user()->username }}" type="text">
                            <small class="text-danger">Username sifatnya unik dan digunakan untuk login</small>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="my-input">Jenis Kelamin</label>
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input id="laki-laki" class="custom-control-input" type="radio" name="jk" value="L" @if ((empty($identitas->jk)?'':$identitas->jk) == "L")
                                            checked
                                        @endif>
                                        <label for="laki-laki" class="custom-control-label">Laki-laki</label>
                                    </div>

                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input id="perempuan" class="custom-control-input" type="radio" name="jk" value="P" @if ((empty($identitas->jk)?'':$identitas->jk) == "P")
                                            checked
                                        @endif>
                                        <label for="perempuan" class="custom-control-label">Perempuan</label>
                                    </div>

                                </div>
                            </div>
                        </div>

                        

                        <div class="form-group">
                            <label for="nip">NIP (Opsional)</label>
                            <input id="nip" class="form-control" placeholder="masukan NIP/kosongkan" type="number" name="nip" value="{{ empty($identitas->nip)?'':$identitas->nip }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input required id="email" class="form-control" placeholder="masukan email" type="email" name="email" value="{{ empty($identitas->email)?'':$identitas->email }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat *</label>
                            <input required id="alamat" class="form-control" placeholder="masukan alamat" type="text" name="alamat" value="{{ empty($identitas->alamat)?'':$identitas->alamat }}">
                        </div>
                        <div class="form-group">
                            <label for="hp">No HP/WA *</label>
                            <input required id="hp" class="form-control" placeholder="masukan noHp/WA" type="number" name="hp" value="{{ empty($identitas->hp)?'':$identitas->hp }}">
                        </div>
                        <div class="form-group">
                            <label for="agama">Agama *</label>
                            <select required id="agama" class="form-control" name="agama">
                                @php
                                    $agama = [
                                        "Islam", 
                                        "Kristen Protestan", 
                                        "Kristen Katolik", 
                                        "Hindu", 
                                        "Buddha", 
                                        "Khonghucu"
                                    ]
                                @endphp
                                @foreach ($agama as $item)
                                    <option value="{{ $item }}" @if ((empty($identitas->agama)?'':$identitas->agama) == $item)
                                        selected
                                    @endif>{{ $item }}</option>
                                    
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="posisi">Posisi *</label>
                            <select required id="posisi" class="form-control" name="posisi">
                                <option value="">Pilih Posisi</option>
                                <option value="guru" @if ((empty($identitas->posisi)?'':$identitas->posisi) == "guru")
                                    selected
                                @endif>Guru</option>
                                <option value="walikelas" @if ((empty($identitas->posisi)?'':$identitas->posisi) == "walikelas")
                                    selected
                                @endif>Wali Kelas</option>
                            </select>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-success px-3">
                            <b>UPDATE DATA DIRI</b>
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

@endsection