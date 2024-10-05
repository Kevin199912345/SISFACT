@extends('layouts.user_type.guest')

@section('content')

<section class="min-vh-100 mb-8">
  <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 text-center mx-auto">
          <h1 class="text-white mb-2 mt-5">Welcome!</h1>
          <p class="text-lead text-white">Use these awesome forms to login or create new account in your project for free.</p>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row mt-lg-n10 mt-md-n11 mt-n10">
      <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
        <div class="card z-index-0">
          <div class="card-header text-center pt-4">
            <h5>Register with</h5>
          </div>
          <div class="row px-xl-5 px-sm-4 px-3">
            <!-- Opciones para registrar con redes sociales -->
          </div>
          <div class="card-body">
            
            <!-- Mostrar mensajes flash -->
            @if (session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif

            @if (session('error'))
              <div class="alert alert-danger">
                {{ session('error') }}
              </div>
            @endif

            <form role="form text-left" method="POST" action="{{ route('register_store') }}">
              @csrf
              
              <!-- Nombre -->
              <div class="mb-3">
                <input type="text" class="form-control" placeholder="Name" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <!-- Correo -->
              <div class="mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <!-- Contraseña -->
              <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                @error('password')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <!-- Confirmar contraseña -->
              <div class="mb-3">
                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation">
                @error('password_confirmation')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <!-- Términos y condiciones -->
              <div class="form-check form-check-info text-left">
                <input class="form-check-input" type="checkbox" id="terms" name="terms">
                <label class="form-check-label" for="terms">
                  I agree to the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                </label>
                @error('terms')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <!-- Botón de registro -->
              <div class="text-center">
                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
              </div>

              <!-- Link a la página de login -->
              <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Sign in</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
