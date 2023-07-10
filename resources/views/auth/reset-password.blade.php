@extends('partials.layouts.auth')

@section('documentTitle')
  Khôi phục mật khẩu
@endsection

@section('content')
  <div class="brand-logo text-center">
    <h2 class="font-weight-bold" style="color: #4B49AC;">ShioSMS</h2>
  </div>

  <form class="pt-3" action="{{ route('password.update') }}" method="POST">
    @csrf

    <input type="text" name="token" value="{{ $token }}" hidden>

    <div class="form-group login-formGroup">
      <i class="fa-solid fa-envelope"></i>
      <input 
        type="text" 
        class="form-control form-control-lg font-weight-bold" 
        style="{{ $errors->has('email') ? 'border: 1px solid #dc3545' : '' }}"
        name="email"
        value="{{ old('email') }}"
        placeholder="Email">

      @error('email')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group login-formGroup">
      <i class="fa-solid fa-key"></i>
      <input 
        type="password" 
        class="form-control form-control-lg font-weight-bold" 
        style="{{ $errors->has('password') ? 'border: 1px solid #dc3545' : '' }}"
        name="password" 
        placeholder="Mật khẩu mới">

      @error('password')
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>

    <div class="form-group login-formGroup">
      <i class="fa-solid fa-key"></i>
      <input 
        type="password" 
        class="form-control form-control-lg font-weight-bold" 
        name="password_confirmation" 
        style="{{ $errors->has('password_confirmation') ? 'border: 1px solid #dc3545' : '' }}"
        placeholder="Nhập lại mật khẩu">
      
      @error('password_confirmation')
      <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-3">
      <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Đổi mật khẩu</button>
    </div>
   
  
  </form>

  </form>
@endsection
