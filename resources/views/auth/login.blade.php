@extends('partials.layouts.auth')

@section('documentTitle') Đăng nhập @endsection

@section('content')

<div class="brand-logo text-center">
  <h2 class="font-weight-bold" style="color: #4B49AC;">ShioSMS</h2>
</div>

<form class="pt-3" action="{{ route('login') }}" method="POST">
  @csrf

  <x-form-message></x-form-message>

  <div class="p-3 mb-3 text-light" style="background-color: #4B49AC; font-size: 12px;">
    <div class="mb-1">Tài khoản giáo vụ: nv2@gmail.com / MK: 123456</div>
    <div class="mb-1">Tài khoản giáo viên: gv1@gmail.com / MK: 123456</div>
    <div class="mb-1">Tài khoản học sinh: hs1@gmail.com / MK: 123456</div>
  </div>

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
    <a data-toggle="modal" data-target="#requireAuthModal" class="auth-link text-black" style="cursor: pointer;">Quên mật khẩu ?</a>
  </div>

  <div class="mt-3">
    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Đăng nhập</button>
  </div>

</form>

<div class="modal fade" id="requireAuthModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="fs-3 fw-bold">
          Chức năng "Quên mật khẩu" không hiệu lực ở chế độ này.
        </div>
        <div  class="fs-5">
          Bạn có thể truy cập link demo này để xem mô tả chức năng: <a href="" class="color-main">Link Demo</a>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
@endsection
