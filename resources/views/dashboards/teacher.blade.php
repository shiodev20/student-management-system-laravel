@extends('partials.layouts.main')

@section('documentTitle')
  Trang chủ
@endsection

@section('content')
<div class="row">
  <div class="col">
    <div class="card">

      <div class="card-body">

        <div class="row">

          <div class="col-md-3 mb-3">
            <label for="">Năm học hiện tại</label>
            <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $currentYear->name }}" readonly>
          </div>
          
          <div class="col-md-3 mb-3">
            <label for="">Học kỳ hiện tại</label>
            <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $currentSemester->name }}" readonly>
          </div>
        </div>

        <hr>

        <div class="row">

          <div class="col">
            
            <div class="mb-3">
              @if ($headClassroom)
                <a href="{{ route('teachers.showHeadClassroom', ['teacher' => $currentUser['id'], 'classroom' => $headClassroom->id]) }}" class="btn btn-primary btn-sm">Lớp chủ nhiệm</a>
              @else
                <button class="btn btn-primary btn-sm" disabled>Lớp chủ nhiệm</button>
              @endif
            </div>


            <div class="card-title">Lớp học đang giảng dạy</div>

            <ul class="nav nav-tabs">
              @foreach ($grades as $grade)
              <li class="nav-item">
                <a 
                  class="nav-link font-weight-bold {{ $loop->index == 0 ? 'active' : '' }}"
                  id="{{ "$grade->id-tab" }}" 
                  data-toggle="tab" 
                  href="{{ "#$grade->id" }}" 
                  role="tab"
                >
                  {{ $grade->name }}
                </a>
              </li>
              @endforeach
            </ul>

            <div class="tab-content">
              @foreach ($grades as $grade)
                <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : '' }}" id="{{ $grade->id }}">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="table-primary">
                        <tr>
                          <th>Mã lớp</th>
                          <th>Năm học</th>
                          <th>khối lớp</th>
                          <th>Tên lớp</th>
                          <th>Sỉ số</th>
                          <th>Giáo viên chủ nhiệm</th>
                          <th>Lựa chọn</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach ($teachingClassrooms as $classroom)
                          @if ($classroom->grade_id == $grade->id)
                            <tr>
                              <td class="font-weight-bold">{{ $classroom->id }}</td>
                              <td class="font-weight-bold">{{ $classroom->year->name }}</td>
                              <td class="font-weight-bold">{{ $classroom->grade->name }}</td>
                              <td class="font-weight-bold">{{ $classroom->name }}</td>
                              <td class="font-weight-bold">{{ $classroom->size }}</td>
                              <td class="font-weight-bold">{{ $classroom->headTeacher ? $classroom->headTeacher->first_name.' '.$classroom->headTeacher->last_name : '' }}</td>
                              <td>
                                <div class="d-flex justify-content-start">
                                  <a href="{{ route('marks.edit', ['classroom' => $classroom->id]) }}" class="btn btn-primary btn-sm">Nhập điểm</a>
                                </div>
                              </td>
                            </tr>
                          @endif
                        @endforeach
                      </tbody>

                    </table>
                  </div>
                </div>
              @endforeach
            </div>

          </div>

        </div>

      </div>

    </div>
  </div>
</div>
@endsection

