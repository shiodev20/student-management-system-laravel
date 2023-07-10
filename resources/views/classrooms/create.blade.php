@extends('partials.layouts.main')

@section('documentTitle')
  Mở lớp
@endsection

@section('content')
<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        
        {{-- Classrooms create --}}
        <div class="card-title">Mở lớp học</div>
        <div>
          <form action="{{ route('classrooms.store') }}" method="POST" id="createClassroomForm">
            @csrf
            
            <div class="form-group row">

              {{-- Year input --}}
              <div class="col-md-3 col-sm-12 mb-2">
                <label class="mr-sm-2 mb-2 font-weight-bold" for="info">Năm học</label>
                <input type="text" id="info" name="year" value="{{ $currentYear->id }}" readonly hidden>
                <input 
                  type="text" 
                  id="info" 
                  class="form-control form-control-sm mb-3 mr-sm-5 font-weight-bold" 
                  style="{{ $errors->has('year') ? 'border: 1px solid #dc3545' : '' }}"
                  value="{{ $currentYear->name }}" 
                  readonly
                >
                @error('year')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Grade input --}}
              <div class="col-md-3 col-sm-12 mb-2">
                <label class="mr-sm-2 mb-2 font-weight-bold" for="type">Khối lớp</label>
                <select 
                  class="form-control form-control-sm mb-3 mr-sm-5 font-weight-bold" 
                  id="type" 
                  name="grade"
                  style="{{ $errors->has('grade') ? 'border: 1px solid #dc3545' : '' }}"
                >
                  <option value="">Lựa chọn</option>
                  @foreach ($grades as $grade)
                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                  @endforeach
                </select>
                @error('grade')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Quantity input --}}
              <div class="col-md-3 col-sm-12 mb-2">
                <label class="mr-sm-2 mb-2 font-weight-bold" for="info">Số lượng</label>
                <input 
                  type="number" 
                  id="info" 
                  name="quantity" 
                  class="form-control form-control-sm mb-3 mr-sm-5 font-weight-bold"
                  value="{{ $errors->has('quantity') ? old('quantity') : '0' }}"
                  style="{{ $errors->has('quantity') ? 'border: 1px solid #dc3545' : '' }}"
                >
                @error('quantity')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>

              {{-- Classrooms create button --}}
              <div class="col-md-3 col-sm-12 {{ $errors->has('year') || $errors->has('grade') || $errors->has('quantity') ? 'align-self-center' : 'align-self-end mb-2' }}">
                <button type="submit" class="btn btn-primary mb-3">Mở lớp</button>
              </div>

            </div>

          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  const inputs = document.querySelectorAll('#createClassroomForm input')
  const selects = document.querySelectorAll('#createClassroomForm select')

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