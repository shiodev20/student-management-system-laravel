@extends('partials.layouts.main')

@section('documentTitle')
  Quản lý niên khóa
@endsection


@section('content')
<div class="card">
  <div class="card-body">
    <div class="card-title">Quản lý niên khóa</div>

    <form action="{{ route('schoolYears.update') }}" method="POST">
      @csrf
      @method('PUT')
      
      <div class="row">
        <div class="col-md-3 col-sm-12 mb-3">
          <label for="">Năm học hiện tại</label>
          <select name="year" class="form-control font-weight-bold">
            @foreach ($years as $year)
            <option value="{{ $year->id }}" {{ $year->status ? 'selected' : '' }} >{{ $year->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3 col-sm-12 mb-3">
          <label for="">Học kỳ hiện tại</label>
          <select name="semester" class="form-control font-weight-bold">
            @foreach ($semesters as $semester)
              <option value="{{ $semester->id }}" {{ $semester->status ? 'selected' : '' }}>{{ $semester->name }}</option>
            @endforeach
          </select>
        </div>

      </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
      
  </div>
</div>
@endsection