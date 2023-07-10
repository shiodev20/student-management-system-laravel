@extends('partials.layouts.main')

@section('documentTitle')
  Quản lý quy định
@endsection


@section('content')
<div class="card">
  <div class="card-body">
    <div class="card-title">Quản lý quy định</div>

    <form action="{{ route('rules.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row">
        @foreach ($rules as $rule)
          <div class="col-md-3 col-sm-12 mb-3">
            <label for="">{{ $rule['name'] }}</label>
            <input 
              type="text" 
              class="form-control font-weight-bold" 
              style="{{ $errors->has($rule['key']) ? 'border: 1px solid #dc3545' : '' }}"
              name="{{ $rule['key'] }}" 
              value="{{ $rule['value'] }}">

              @error($rule['key'])
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
          </div>
        @endforeach
        
        <div class="col-md-3 col-sm-12 mb-3">
          <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
      </div>
    </form>
      
  </div>
</div>
@endsection