@extends('partials.layouts.main')

@section('documentTitle')
  {{ $classroom->id }} - Phân công giáo viên bộ môn
@endsection

@section('content')
<div class="row">

  <div class="col-12 grid-margin">
    
    <div class="card">
      <div class="card-body">
        <div class="card-title">Phân công giáo viên bộ môn</div>

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
            <label>Giáo viên chủ nhiệm</label>
            <input 
              type="text" 
              class="form-control form-control-sm font-weight-bold" 
              value="{{ $classroom->headTeacher ? $classroom->headTeacher->first_name.' '.$classroom->headTeacher->last_name : '' }}" 
              readonly
            >
          </div>
        </div>
        
        <hr>

        {{-- Classroom assing subjectTeacher form --}}
        <form action="{{ route('classrooms.processAssignSubjectTeacher', ['classroom' => $classroom->id ]) }}" method="POST" id="assignSubjectTeacherForm">
          @csrf
          @method('PUT')

          <button type="submit" class="btn btn-primary mb-4">Cập nhật</button>
        
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Mã môn học</th>
                  <th>Môn học</th>
                  <th>Giáo viên</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($subjects as $subject)
                  <tr>
                    <th>{{ $loop->index + 1 }}</th>
                    <td class="font-weight-bold">{{ $subject->id }}</td>
                    <td class="font-weight-bold">{{ $subject->name }}</td>
                    <td>
                      <select name="{{ $subject->id }}" class="form-control form-control-sm font-weight-bold">
                        <option value="">Chọn</option>
                        @foreach ($subject->teachers as $teacher)
                          <option value="{{ $teacher->id }}">{{ $teacher->id.' - '.$teacher->first_name.' '.$teacher->last_name }}</option>
                        @endforeach
                      
                      </select>
                    </td>
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