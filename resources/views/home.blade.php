@extends('layouts.master')

@section('warnahome', 'active')

@section("judul", "Dashboard")
@section('content')
  <div class="container">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-user"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">JUMLAH GURU</span>
                    <span class="info-box-number">
                        {{$guru}}
                    </span>
                </div>

            </div>
        </div>
    
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1">
                    <i class="fas fa-user-circle"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">JUMLAH WALIKELAS</span>
                    <span class="info-box-number">
                        {{$walikelas}}
                    </span>
                </div>

            </div>
        </div>
    
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">JUMLAH SISWA</span>
                    <span class="info-box-number">
                        {{$siswa}}
                    </span>
                </div>

            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-4 col-6">
    
            <div class="small-box bg-info text-center">
                <div class="inner">
                    <h3>{{ $raport }}</h3>
                    <p>Raport</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cog"></i>
                </div>
                <a href="{{ url('raport', []) }}" class="small-box-footer">More info
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
    
        </div>

    </div>
  </div>

@endsection