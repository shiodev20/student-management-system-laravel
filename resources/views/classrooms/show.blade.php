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
        <div class="card-title">Thông tin lớp học</div>

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
            @if ($classroom->head_teacher_id)
            
              @if ($classroom->year_id == $currentYear->id)
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
                <div class="input-group">
                  <input 
                    type="text" 
                    class="form-control form-control-sm font-weight-bold" 
                    value="{{ $classroom->headTeacher ? $classroom->headTeacher->first_name.' '.$classroom->headTeacher->last_name : '' }}" 
                    readonly
                  >
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-sm btn-danger" disabled><i class='fa-solid fa-trash'></i></button>
                  </div>
                </div>
              @endif
              
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

        <label for="">Lựa chọn:</label><br>
        
        <a 
          href="{{ route('classrooms.assignStudent', [ 'classroom' => $classroom->id ]) }}"
          class="btn btn-primary btn-sm mb-3 mr-1 {{ $classroom->year_id != $currentYear->id ? 'disabled' : '' }}"
        >Thêm học sinh</a>
        <a 
          href="{{ route('classrooms.assignHeadTeacher', [ 'classroom' => $classroom->id ]) }}"
          class="btn btn-primary btn-sm mb-3 mr-1 {{ $classroom->year_id != $currentYear->id ? 'disabled' : '' }}"
        >Phân công GVCN</a>
        <a 
          href="{{ route('classrooms.assignSubjectTeacher', [ 'classroom' => $classroom->id ]) }}"
          class="btn btn-primary btn-sm mb-3 mr-1 {{ $classroom->year_id != $currentYear->id ? 'disabled' : '' }}"
        >Phân công GVBM</a>

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

            @if (count($students) > 0)
              <div class="d-flex mb-3">

                <a href="{{ route('exports.studentList', ['classroom' => $classroom->id]) }}" class="mr-2">
                  <button class="btn btn-primary btn-sm btn-icon-text">
                    <i class='fa-solid fa-file btn-icon-prepend'></i>Xuất danh sách học sinh
                  </button>
                </a>

                @if ($classroom->year_id == $currentYear->id)
                  <x-delete-confirm-button
                    :url="route('classrooms.deleteAllStudents', ['classroom' => $classroom->id])"
                    :message=" 'tất cả học sinh của lớp '.$classroom->id"
                  >Xóa tất cả học sinh</x-delete-confirm-button>
                @else
                  <button type="submit" class="btn btn-danger btn-sm" disabled>Xóa tất cả học sinh</button>
                @endif

              </div>
            @endif

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
                          href="{{ route('students.show', ['student' => $student->id])."?year=$classroom->year_id&semester=$currentSemester->id" }}"
                        >
                          <button class="btn btn-info btn-sm"><i class="fa-solid fa-chart-simple" style="font-size: 0.8rem;"></i></button>
                        </a>
                        
                        @if ($classroom->year_id == $currentYear->id)
                          <x-delete-confirm-button
                            :url="route('classrooms.deleteStudent', ['classroom' => $classroom->id, 'student' => $student->id])"
                            :message=" ' học sinh '.$student->id.' khỏi lớp '.$classroom->id"
                          ><i class='fa-solid fa-trash' style="font-size: 0.8rem;"></i></x-delete-confirm-button>
                        @else
                          <button class="btn btn-danger btn-sm" disabled><i class='fa-solid fa-trash' style="font-size: 0.8rem;"></i></button>
                        @endif
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

            <div class="d-flex mb-3">
              <a href="{{ route('exports.subjectTeacherList', ['classroom' => $classroom->id]) }}" class="mr-2">
                <button class="btn btn-primary btn-sm btn-icon-text">
                  <i class='fa-solid fa-file btn-icon-prepend'></i>Xuất danh sách giáo viên
                </button>
              </a>

              @if ($classroom->year_id == $currentYear->id)
                <x-delete-confirm-button
                  :url="route('classrooms.deleteAllSubjectTeachers', ['classroom' => $classroom->id])"
                  :message=" 'tất cả giáo viên bộ môn của lớp '.$classroom->id"
                >Xóa tất cả GVBM</x-delete-confirm-button>
              @else
                <button type="submit" class="btn btn-danger btn-sm" disabled>Xóa tất cả giáo viên</button>
              @endif
            </div>

            <div class="table-responsive">
              <table class="table table-hover table-striped">

                <thead class="table-primary">
                  <tr>
                    <th>STT</th>
                    <th>Mã môn học</th>
                    <th>Môn học</th>
                    <th>Mã giáo viên</th>
                    <th>Tên giáo viên</th>
                    <th>Lựa chọn</th>
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
                      <td>
                        <div class="d-flex justify-content-start">
                          @if ($classroom->year_id == $currentYear->id && $item->subjectTeacher->id != $classroom->head_teacher_id)
                            <x-delete-confirm-button 
                              :url="route('classrooms.deleteSubjectTeacher', ['classroom' => $classroom->id, 'teacher' => $item->subjectTeacher->id])"
                              :message="'giáo viên '.$item->subjectTeacher->id"
                            ><i class='fa-solid fa-trash' style="font-size: .8rem;"></i></x-delete-confirm-button>
                          @else
                            <button class="btn btn-danger btn-sm" disabled><i class='fa-solid fa-trash' style="font-size: .8rem;"></i></button>
                          @endif
                        </div>
                      </td>
                    @else
                      <td></td>
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