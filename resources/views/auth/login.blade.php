@extends('layouts.login')

@section('content')
<section class="h-100 gradient-form" style="background-color: #eeeeee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">
  
                  <div class="text-center">
                    
                    <h4 class="mt-1 mb-5 pb-1"><b>E-RAPORT</b></h4>
                  </div>
  
                  <form method="POST" action="{{ route('login') }}">
                    @csrf
  
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example11">Username</label>
                        <input id="form2Example11" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      
                    </div>
  
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example22">Password</label>
                        <input id="form2Example22" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      
                    </div>

                    
                    <div class="form-outline mb-4">
                        <div class="">
                            <div class="form-check">
                                <input class="form-check-input " type="checkbox"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
  
                    <div class="text-center pt-1 mb-5 pb-1">
                      <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Log
                        in</button>
                      {{-- <a class="text-muted" href="#!">Forgot password?</a> --}}
                    </div>
  
                  </form>
  
                </div>
              </div>

              <div class="col-lg-6 d-flex align-items-center gradient-custom-2 text-center">
                
                  
                  
                  <table width="100%">
                    <tr>
                        <td><h4 class="my-0 mt-2 text-white">Selamat datang di E-Raport</h4></td>
                    </tr>
                    <tr>
                        <td><h2 class="my-0 mb-2 text-white text-bold ">SMKN 1 GUNUNG KIJANG</h2></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <img src="{{ url('gambar', ['logo.png']) }}" style="width: 185px;" alt="logo">
                        </td>
                    </tr>

                  </table>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
