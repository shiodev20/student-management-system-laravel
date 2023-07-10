@extends('partials.layouts.main')

@section('documentTitle')
  Nhập điểm môn {{ $subject->name }} - lớp {{ $classroom->id }}
@endsection

@section('content')
<div class="row">

  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="card-title">Nhập điểm môn {{ $subject->name }} - lớp {{ $classroom->id }}</div>

          <div class="form-group row">

            <div class="col-md-4 col-sm-12 mb-3">
              <label>Năm học</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $currentYear->name }}" readonly>
            </div>

            <div class="col-md-4 col-sm-12 mb-3">
              <label>Học kỳ</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $currentSemester->name }}" readonly>
            </div>

            <div class="col-md-4 col-sm-12 mb-3">
              <label>Mã Lớp học</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" name="classroomId" value="{{ $classroom->id }}" readonly>
            </div>

            <div class="col-md-4 col-sm-12 mb-3">
              <label>Lớp học</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->name }}" readonly>
            </div>

            <div class="col-md-4 col-sm-12 mb-3">
              <label>Sĩ số</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->size }}" readonly>
            </div>

            <div class="col-md-4 col-sm-12 mb-3">
              <label>Giáo viên chủ nhiệm</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $classroom->headTeacher ? $classroom->headTeacher->first_name.' '.$classroom->headTeacher->last_name : '' }}" readonly>
            </div>

          </div>

          <hr>

          <form action="{{ route('marks.update', ['classroom' => $classroom->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="text" name="year" value={{ $currentYear->id}} hidden>
            <input type="text" name="semester" value={{ $currentSemester->id}} hidden>
            <input type="text" name="subject" value={{ $subject->id}} hidden>

            <div class="card-title">Bảng điểm</div>
            
            <div class="mb-4">
              <button type="submit" class="btn btn-primary btn-sm mr-2">Cập nhật</button>
              <a 
                href="{{ route('marks.updateAverageMark', ['classroom' => $classroom->id])."?year=$currentYear->id&semester=$currentSemester->id&subject=$subject->id" }}" 
                class="btn btn-primary btn-sm btn-icon-text"
              >
                <i class="fa-solid fa-calculator btn-icon-prepend"></i>Tính điểm trung bình</a>
            </div>

            
            <div class="table-responsive">
              <table class="table table-hover">
                <thead class="table-primary">
                  <tr>
                    <th>STT</th>
                    <th>Mã học sinh</th>
                    <th>Họ</th>
                    <th>Tên</th>
                    @foreach ($markTypes as $markType)
                      <th>{{ $markType->name }}</th>
                    @endforeach
                  </tr>
                </thead>
        
                <tbody>
                  @foreach ($students as $student)
                    <tr>
                      <th>{{ $loop->index + 1 }}</th>
                      <td class="font-weight-bold"><input type="text" name="students[]" value="{{ $student->id }}" hidden readonly>{{ $student->id }}</td>
                      <td class="font-weight-bold">{{ $student->first_name }}</td>
                      <td class="font-weight-bold">{{ $student->last_name }}</td>

                      @foreach ($markTypes as $markType)
                        @foreach ($student->marks as $mark)
                            @if ($markType->id == $mark->mark_type_id)
                              <td>
                                <input 
                                  style="min-width: 60px; max-width: 100px;"
                                  class="form-control form-control-sm font-weight-bold form-control form-control-sm font-weight-bold text-center text-md-left" 
                                  type="text"
                                  name="{{ $mark->mark_type_id == $markTypes[count($markTypes) - 1]->id ? '' : $markType->id.'[]' }}"
                                  value="{{ number_format($mark->mark, 1) }}" 
                                  {{ $mark->mark_type_id == $markTypes[count($markTypes) - 1]->id ? 'readonly' : '' }}
                                >
                              </td>
                            @endif
                        @endforeach
                      @endforeach
                    </tr>
                  @endforeach
                </tbody>

              </table>
            </div>

          </form>

      </div>
    </div>
  </div>

</div>
@endsection