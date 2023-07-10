@extends('partials.layouts.auth')

@section('documentTitle') Đăng nhập @endsection

@section('content')

<div class="brand-logo text-center">
  <h2 class="font-weight-bold" style="color: #4B49AC;">ShioSMS</h2>
</div>

<form class="pt-3" action="{{ route('login') }}" method="POST">
  @csrf

  <x-form-message></x-form-message>

  <div class="form-group login-formGroup">
    <i class="fa-solid fa-user"></i>
    <input 
      type="text"
      class="form-control form-control-lg font-weight-bold"
      name="email"
      placeholder="Email"
      style="{{ $errors->has('email') ? 'border: 1px solid #dc3545' : '' }}"
      value="{{ old('email')}}"
    >
    @error('email')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group login-formGroup">
    <i class="fa-solid fa-lock"></i>
    <input 
      type="password"
      class="form-control form-control-lg font-weight-bold"
      name="password"
      placeholder="Mật khẩu"
      style="{{ $errors->has('password') ? 'border: 1px solid #dc3545' : '' }}"
    >
    @error('password')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="my-4 d-flex justify-content-end align-items-center">
    <a href="{{ route('password.request') }}" class="auth-link text-black">Quên mật khẩu ?</a>
  </div>

  <div class="mt-3">
    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Đăng nhập</button>
  </div>
 
</form>

@endsection