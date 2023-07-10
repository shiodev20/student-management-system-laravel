@extends('partials.layouts.main')

@section('documentTitle')
  Cập nhật học sinh {{ $student->id }}
@endsection

@section('content')
<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title" style="margin-bottom: 2rem">Cập nhật học sinh {{ $student->id }}</h4>
        <form action="{{ route('students.update', ['student' => $student->id]) }}" method="POST" id="editStudentForm">
          @method('PUT')
          @csrf

          {{-- First name - Last name --}}
          <div class="row">
            {{-- First name --}}
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold" for="first_name">Họ (tên lót) <small>*</small></label>
                <div class="col-sm-9">
                  <input 
                    style="{{ $errors->has('first_name') ? 'border: 1px solid #dc3545' : '' }}"
                    type="text" class="form-control form-control-sm  font-weight-bold" id="first_name" name="first_name"
                    value="{{ old('first_name') ? old('first_name') : $student->first_name }}"
                  >
                  @error('first_name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            {{-- last name --}}
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold" for="last_name">Tên <small>*</small></label>
                <div class="col-sm-9">
                  <input 
                    style="{{ $errors->has('last_name') ? 'border: 1px solid #dc3545' : '' }}"
                    type="text" class="form-control form-control-sm  font-weight-bold" id="last_name" name="last_name"
                    value="{{ old('last_name') ? old('last_name') : $student->last_name }}"
                  >
                  @error('last_name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          {{-- Dob - Gender --}}
          <div class="row">

            {{-- Dob --}}
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold" for="dob">Ngày sinh <small>*</small></label>
                <div class="col-sm-9">
                  <input 
                    style="{{ $errors->has('dob') ? 'border: 1px solid #dc3545' : '' }}"
                    type="date" class="form-control form-control-sm  font-weight-bold" id="dob" name="dob"
                    value="{{ old('dob') ? old('dob') : $student->dob }}"
                  >
                  @error('dob')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            {{-- Gender --}}
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold" for="gender">Giới tính <small>*</small></label>
                <div class="col-sm-9">
                  <select style="{{ $errors->has('gender') ? 'border: 1px solid #dc3545' : '' }}" class="form-control form-control-sm  font-weight-bold" id="gender" name="gender">

                    @if ($student->gender == '1')
                      <option value="">Lựa chọn</option>
                      <option value="1" selected>Nam</option>
                      <option value="0">Nữ</option>

                    @elseif ($student->gender == '0')
                      <option value="">Lựa chọn</option>
                      <option value="1">Nam</option>
                      <option value="0" selected>Nữ</option>
                    @else
                      <option value="" selected>Lựa chọn</option>
                      <option value="1">Nam</option>
                      <option value="0">Nữ</option>
                    @endif
                   
                  </select>
                  @error('gender')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

          </div>

          {{--Address - Email --}}
          <div class="row">

            {{-- Address --}}
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold" for="address">Địa chỉ <small>*</small></label>
                <div class="col-sm-9">
                  <input 
                    style="{{ $errors->has('address') ? 'border: 1px solid #dc3545' : '' }}"
                    type="text" class="form-control form-control-sm  font-weight-bold" id="address" name="address"
                    value="{{ old('address') ? old('address') : $student->address }}"
                  >
                  @error('address')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            {{-- Email --}}
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold" for="email">Email <small>*</small></label>
                <div class="col-sm-9">
                  <input 
                    style="{{ $errors->has('email') ? 'border: 1px solid #dc3545' : '' }}"
                    type="text" class="form-control form-control-sm  font-weight-bold" id="email" name="email"
                    value="{{ old('email') ? old('email') : $student->email }}"
                  >
                  @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

          </div>

          {{-- Parent Name - Parent Phone --}}
          <div class="row">

            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold" for="parent_name">Họ tên phụ huynh <small>*</small></label>
                <div class="col-sm-9">
                  <input 
                    style="{{ $errors->has('parent_name') ? 'border: 1px solid #dc3545' : '' }}"
                    type="text" class="form-control form-control-sm  font-weight-bold" id="parent_name" name="parent_name"
                    value="{{ old('parent_name') ? old('parent_name') : $student->parent_name }}"
                  >
                  @error('parent_name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
               
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label font-weight-bold" for="parent_phone">SĐT phụ huynh <small>*</small></label>
                <div class="col-sm-9">
                  <input 
                    style="{{ $errors->has('parent_phone') ? 'border: 1px solid #dc3545' : '' }}"
                    type="text" class="form-control form-control-sm  font-weight-bold" id="parent_phone" name="parent_phone"
                    value="{{ old('parent_phone') ? old('parent_phone') : $student->parent_phone }}"
                  >
                  @error('parent_phone')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

          </div>

          <button type="submit" class="btn btn-primary ml-auto">Cập nhật</button>
        </form>
      </div>

    </div>
  </div>
</div>

@endsection

@push('js')
<script>
  const inputs = document.querySelectorAll('#editStudentForm input')
  const selects = document.querySelectorAll('#editStudentForm select')

  inputs.forEach(input => {
    input.addEventListener('input', () => {
      input.style.border = '1px solid #CED4DA'
      const invalidFeedBack = document.querySelector(`input[id=${input.id}] + .invalid-feedback`)
      if(invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
    })
  })

  selects.forEach(select => {
    select.addEventListener('change', () => {
      select.style.border = '1px solid #CED4DA'
      const invalidFeedBack = document.querySelector(`select[id=${select.id}] + .invalid-feedback`)
      if(invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
    })
  })
</script>
@endpush