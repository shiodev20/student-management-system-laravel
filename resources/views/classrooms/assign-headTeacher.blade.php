@extends('partials.layouts.main')

@section('documentTitle')
  {{ $classroom->id }} - Phân công giáo viên chủ nhiệm
@endsection

@section('content')
<div class="row">


  <div class="col-12 grid-margin">
   
    <div class="card">
      <div class="card-body">
        <div class="card-title">Phân công giáo viên chủ nhiệm</div>

        {{-- Classroom info --}}
        <div class="row">

          <div class="col-md-4 col-sm-12 mb-4">
            <label>Mã lớp</label>
            <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->id }}" readonly>
          </div>

          <div class="col-md-4 col-sm-12 mb-4">
            <label>Năm học</label>
            <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->year->name }}" readonly>
          </div>

          <div class="col-md-4 col-sm-12 mb-4">
            <label>Khối lớp</label>
            <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->grade->name}}" readonly>
          </div>

          <div class="col-md-4 col-sm-12 mb-4">
            <label>Tên lớp</label>
            <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->name }}" readonly>
          </div> 

          <div class="col-md-4 col-sm-12 mb-4">
            <label>Sĩ số</label>
            <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->size }}" readonly>
          </div> 
          
          <div class="col-md-4 col-sm-12 mb-4">
            @if ($classroom->head_teacher_id)
              <label>Giáo viên chủ nhiệm</label>
              <div class="input-group">
                <input 
                  type="text" 
                  class="form-control form-control-sm font-weight-bold" 
                  value="{{ $classroom->headTeacher ? $classroom->headTeacher->first_name.' '.$classroom->headTeacher->last_name : '' }}" 
                  readonly
                >
                <div class="input-group-append">
                  <x-delete-confirm-button
                    :url="route('classrooms.deleteHeadTeacher', ['classroom' => $classroom->id])"
                    :message="'giáo viên chủ nhiệm của lớp '.$classroom->id"
                  ><i class='fa-solid fa-trash' style="font-size: .8rem;"></i></x-delete-confirm-button>
                </div>
              </div>
            @else
              <label>Giáo viên chủ nhiệm</label>
              <input 
                type="text" 
                class="form-control form-control-sm font-weight-bold" 
                value=""
                readonly
              >
            @endif
          </div>
        </div>
        
        <hr>

        {{-- Claasroom assign headTeacher form --}}
        <form action="{{ route('classrooms.processAssignHeadTeacher', ['classroom' => $classroom->id]) }}" method="POST" id="assignHeadTeacherForm">
          @csrf
          @method('PUT')

          <div class="d-flex">
            <button type="submit" class="btn btn-primary btn-sm mb-4">Cập nhật</button>
          </div>
        
          <div class="table-responsive">
            <table class="table table-hover table-striped">
              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Mã giáo viên</th>
                  <th>Họ tên giáo viên</th>
                  <th>Giới tính</th>
                  <th>Môn giảng dạy</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($teachers as $teacher)
                  <tr>
                    <th>{{ $loop->index + 1 }}</th>
                    <td class="font-weight-bold">{{ $teacher->id }}</td>
                    <td class="font-weight-bold">{{ $teacher->first_name.' '.$teacher->last_name }}</td>
                    <td class="font-weight-bold">{{ $teacher->gender ? 'Nam' : 'Nữ'}}</td>
                    <td class="font-weight-bold">{{ $teacher->subject->name }}</td>
                    <td class="d-flex justify-content-center">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="radio" class="form-check-input" name="headTeacher" value="{{ $teacher->id }}">
                        </label>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="mt-4 d-flex justify-content-center justify-content-md-end">
            {{ $teachers->links() }}
          </div>

        </form>

      </div>
    </div>

  </div>

</div>
@endsection