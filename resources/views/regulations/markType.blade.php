@extends('partials.layouts.main')

@section('documentTitle')
  Quản lý học vụ
@endsection


@section('content')
<div class="card">
  <div class="card-body">
    <div class="card-title">Quản lý học vụ</div>

    <form action="{{ route('markTypes.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="row">
        <div class="col">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Mã loại điểm</th>
                  <th>Tên loại điểm</th>
                  <th>Hệ số</th>
                </tr>
              </thead>

              <div class="tbody">
                @foreach ($markTypes as $markType)
                  <tr>
                    <th>{{ $loop->index + 1}}</th>
                    <td class="font-weight-bold">
                      {{ $markType->id }}
                      <input type="text" name="ids[]" value="{{ $markType->id }}" readonly hidden>
                    </td>
                    <td>
                      <input class="form-control form-control-sm font-weight-bold" type="text" name="names[]" value="{{ $markType->name }}">
                    </td>
                    <td>
                      <input 
                        class="form-control form-control-sm font-weight-bold" 
                        type="text" 
                        name="coefficients[]" 
                        value="{{ $markType->coefficient }}"
                        {{ $loop->index == count($markTypes) - 1 ? 'readonly' : ''}}>
                    </td>
                  </tr>
                @endforeach
              </div>
            </table>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 my-3">
          <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection