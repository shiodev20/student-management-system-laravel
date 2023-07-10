@extends('partials.layouts.main')

@section('documentTitle')
  Lớp {{ $classroom->id }}
@endsection

@section('content')
<div class="row">

  {{-- Classroom info --}}
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="card-title">Thông tin lớp học chủ nhiệm</div>

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
            <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->grade->name }}" readonly>
          </div>

          <div class="col-md-4 col-sm-12 mb-4">
            <label>Tên lớp</label>
            <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->name }}" readonly>
          </div> 
          
          <div class="col-md-4 col-sm-12 mb-4">
            <label>Sỉ số</label>
            <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->size }}" readonly>
          </div>

          <div class="col-md-4 col-sm-12 mb-4">
            <label>Giáo viên chủ nhiệm</label>
            <input 
              type="text" 
              class="form-control form-control-sm font-weight-bold" 
              value="{{ $classroom->headTeacher->first_name.' '.$classroom->headTeacher->last_name }}"
              readonly
            >
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Classroom list --}}
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">

        <ul class="nav nav-tabs">
          <li class="nav-item">
            <a class="nav-link font-weight-bold  active" id="studentList-tab" data-toggle="tab" href="#studentList" role="tab">Danh sách lớp học</a>
          </li>
          <li class="nav-item">
            <a class="nav-link font-weight-bold " id="subjectTeacherList-tab" data-toggle="tab" href="#subjectTeacherList" role="tab" >Danh sách GVBM</a>
          </li>
        </ul>

        <div class="tab-content">

          {{-- Student list --}}
          <div class="tab-pane fade show active" id="studentList">

            <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead class="table-primary">
                  <tr>
                    <th>STT</th>
                    <th>Mã học sinh</th>
                    <th>Họ</th>
                    <th>Tên</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
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
                    <td class="font-weight-bold">{{ date_format(date_create($student->dob), 'd-m-Y') }}</td>
                    <td class="font-weight-bold">{{ $student->gender ? 'Nam' : 'Nữ' }}</td>
                    <td>
                      <div class="d-flex justify-content-start">
                        <a 
                          class="mr-2"
                          href="{{route('teachers.showHeadClassroomStudent', [
                            'student' => $student->id,
                            'classroom' => $classroom->id,
                            'teacher' => $currentUser['id'],
                          ])."?semester=$currentSemester->id"}}"
                        >
                          <button class="btn btn-info btn-sm"><i class="fa-solid fa-chart-simple" style="font-size: 0.8rem;"></i></button>
                        </a>
                      </div>
                    </td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>


          {{-- Subject teacher list --}}
          <div class="tab-pane fade" id="subjectTeacherList">
            <div class="table-responsive">
              <table class="table table-hover table-striped">

                <thead class="table-primary">
                  <tr>
                    <th>STT</th>
                    <th>Mã môn học</th>
                    <th>Môn học</th>
                    <th>Mã giáo viên</th>
                    <th>Tên giáo viên</th>
                  </tr>
                </thead>

                <tbody>
                  @foreach ($subjectTeachers as $item)
                  <tr>
                    <th>{{ $loop->index + 1 }}</th>
                    <td class="font-weight-bold">{{ $item->id }}</td>
                    <td class="font-weight-bold">{{ $item->name }}</td>

                    @if ($item->subjectTeacher)
                      <td class="font-weight-bold">{{ $item->subjectTeacher->id }}</td>
                      <td class="font-weight-bold">{{ $item->subjectTeacher->first_name.' '.$item->subjectTeacher->last_name }}</td>
                    @else
                      <td></td>
                      <td></td>
                    @endif

                  </tr>  
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

        </div>
        
      </div>
    </div>
  </div>
  
</div>
@endsection