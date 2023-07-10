@extends('partials.layouts.main')

@section('documentTitle')
  {{ $student->id }}
@endsection

@section('content')
<div class="row">

  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="card-title">Thông tin học sinh</div>

          <div class="row">

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="info">Mã học sinh</label>
              <input type="text" id="info" class="form-control form-control-sm font-weight-bold" value="{{ $student->id }}" readonly>
            </div>
            
            <div class="col-md-3 col-sm-12 mb-3">
              <label for="info">Họ</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $student->first_name }}" readonly>
            </div>

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="info">Tên</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $student->last_name }}" readonly>
            </div>

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="info">Ngày sinh</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ date_format(date_create($student->dob), 'd-m-Y')  }}" readonly>
            </div>

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="info">Giới tính</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $student->gender ? 'Nam' : 'Nữ'  }}" readonly>
            </div>

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="info">Địa chỉ</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $student->address  }}" readonly>
            </div>

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="info">Họ tên phụ huynh</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $student->parent_name  }}" readonly>
            </div>

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="info">Số điện thoại</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $student->parent_phone  }}" readonly>
            </div>

          </div>

      </div>
    </div>
  </div>

  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">

        <div class="card-title">Kết quả học tập</div>

        {{-- Student result searching --}}
        <form 
          action="{{ route('teachers.showHeadClassroomStudent', [ 
            'student' => $student->id, 
            'classroom' => $classroom->id, 
            'teacher' => $currentUser['id'] 
          ]) }}" 
          method="GET"
        >
          <div class="form-group row">

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="info">Lớp</label>
              <input 
                type="text" 
                id="info" 
                class="form-control form-control-sm font-weight-bold" 
                value="{{ $classroom ? $classroom->name : ''}}" 
                readonly>
            </div>

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="year">Năm học</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $currentYear->name }}" readonly>
            </div>

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="year">Học kỳ</label>
              <select class="form-control form-control-sm font-weight-bold" id="semester" name="semester">
                @foreach ($semesters as $semester)
                  <option value="{{ $semester->id }}" {{ $query['semester'] == $semester->id ? 'selected' : '' }}>{{ $semester->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3 col-sm-12 align-self-end mb-3">
              <button type="submit" class="btn btn-primary">Xem điểm</button>
            </div>

          </div>
        </form>

        {{-- Student result --}}
        <div class="table-responsive">
          <table class="table table-hover">

            <thead class="table-primary">
              <tr>
                <th>STT</th>
                <th>Môn học</th>
                @foreach ($markTypes as $markType)
                <th>{{ $markType->name }}</th>
                @endforeach
              </tr>
            </thead>
            
            <tbody>
              @foreach ($studentResult as $subject)
                <tr>
                  <th>{{ $loop->index + 1 }}</th>
                  <td class="font-weight-bold">{{ $subject->name }}</td>
                  
                  @foreach ($subject->marks as $mark)
                    <td>
                      <input 
                        type="text" 
                        class="form-control form-control-sm font-weight-bold text-center text-md-left"
                        style="min-width: 60px; max-width: 100px;"
                        value="{{ number_format($mark->mark, 1) }}" 
                        readonly>
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>

          </table>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection
