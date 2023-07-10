@extends('partials.layouts.auth')

@section('documentTitle')
  Quên mật khẩu
@endsection

@section('content')
  <div class="brand-logo text-center">
    <h2 class="font-weight-bold" style="color: #4B49AC;">ShioSMS</h2>
  </div>

  <form class="pt-3" action="{{ route('password.email') }}" method="POST">
    @csrf
    
    <div class="form-group login-formGroup">
        <i class="fa-solid fa-envelope"></i>
        <input 
            type="text" 
            class="form-control form-control-lg font-weight-bold" 
            style="{{ $errors->has('email') ? 'border: 1px solid #dc3545' : '' }}"
            name="email"
            placeholder="Email">
        
        @error('email')
          <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Lấy lại mật khẩu</button>
    </div>

  </form>
@endsection
