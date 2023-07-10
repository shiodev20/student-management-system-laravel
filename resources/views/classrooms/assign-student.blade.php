@extends('partials.layouts.main')

@section('documentTitle')
  {{ $classroom->id }} - Lập danh sách lớp
@endsection

@section('content')
<div class="row">

  <div class="col-12 grid-margin">
    
    <div class="card">
      <div class="card-body">
        <div class="card-title">Lập danh sách lớp</div>

        {{-- Classroom info --}}
        <div class="row">

          <div class="col-md-4 col-sm-12 mb-4">
            <label for="classroomId">Mã lớp</label>
            <input type="text" id="classroomId" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->id }}" readonly>
          </div>

          <div class="col-md-4 col-sm-12 mb-4">
            <label for="year">Năm học</label>
            <input type="text" id="year" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->year->name }}" readonly>
          </div>

          <div class="col-md-4 col-sm-12 mb-4">
            <label for="grade">Khối lớp</label>
            <input type="text" id="grade" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->grade->name}}" readonly>
          </div>

          <div class="col-md-4 col-sm-12 mb-4">
            <label for="className">Tên lớp</label>
            <input type="text" id="classname" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->name }}" readonly>
          </div> 
          
          <div class="col-md-4 col-sm-12 mb-4">
            <label for="headTeacher">Giáo viên chủ nhiệm</label>
            <input
              id="headTeacher"
              type="text" 
              class="form-control form-control-sm font-weight-bold" 
              value="{{ $classroom->headTeacher ? $classroom->headTeacher->first_name.' '.$classroom->headTeacher->last_name : '' }}" 
              readonly
            >
          </div>
          
        </div>

        <hr>

        {{-- Assign student form --}}
        <form action="{{ route('classrooms.processAssignStudent', [ 'classroom' => $classroom->id ]) }}" method="POST" id="assignStudentForm">
          @csrf
          {{-- Classsize & button --}}
          <div class="row mb-4">

            <div class="col-md-2 mb-4">
              <label>Sĩ số lớp</label>
              <div class="input-group">
                <input type="text" id="classSize" class="form-control font-weight-bold" value="{{ $classroom->size }}" readonly>
                <div class="input-group-append">
                  <span id="classSizeMax" class="input-group-text">{{ $classSize }}</span>
                </div>
              </div>
            </div>

            <div class="col-md-4 align-self-end mb-4">
              <button type="submit" class="btn btn-primary" id="assignStudentButton">Cập nhật</button>
            </div>

          </div>

          {{-- Student list --}}
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="studentAssign">
              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Mã học sinh</th>
                  <th>Họ</th>
                  <th>Tên</th>
                  <th>Giới tính</th>
                  <th>Ngày sinh</th>
                  <th>Lớp cũ</th>
                
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($students as $student)
                  <tr>
                    <th>{{ $loop->index + 1 }}</th>
                    <td class="font-weight-bold">{{ $student->id }}</td>
                    <td class="font-weight-bold">{{ $student->first_name }}</td>
                    <td class="font-weight-bold">{{ $student->last_name }}</td>
                    <td class="font-weight-bold">{{ $student->gender ? 'Nam' : 'Nữ' }}</td>
                    <td class="font-weight-bold">{{ date_format(date_create($student->dob), 'd-m-Y') }}</td>
                    <td class="font-weight-bold">{{ $student->class_name ? $student->class_name : 'Đầu cấp' }}</td>
                    <td class="d-flex justify-content-center">
                      <div class="form-check">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="students[]" value="{{ $student->id }}">
                        </label>
                      </div>
                    </td>
                  </tr>
                @endforeach
              
              </tbody>
            </table>
          </div>
          
          <div class="mt-4 d-flex justify-content-center justify-content-md-end">
            {{ $students->links() }}
          </div>
        </form>
        
      </div>
    </div>

  </div>

</div>
@endsection