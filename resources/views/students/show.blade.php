@extends('partials.layouts.main')

@section('documentTitle')
  {{ $student->id }}
@endsection

@section('content')
<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="card-title">Thông tin học sinh {{ $student->id }}</div>

          <div class="row">

           
            
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

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="info">email</label>
              <input type="text" id="info" class="form-control form-control-sm font-weight-bold" value="{{ $student->email }}" readonly>
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
        <form action="{{ route('students.show', ['student' => $student->id]) }}" method="GET">
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
              <select class="form-control form-control-sm font-weight-bold" id="year" name="year">
                @foreach ($years as $year)
                  <option value="{{ $year->id }}" {{ $query['year'] == $year->id ? 'selected' : '' }}>{{ $year->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-3 col-sm-12 mb-3">
              <label for="year">Học kỳ</label>
              <select class="form-control form-control-sm font-weight-bold" id="semester" name="semester">
                @foreach ($semesters as $semester)
                  <option value="{{ $semester->id }}" {{ $query['semester'] == $semester->id ? 'selected' : '' }}>{{ $semester->name }}</option>
                @endforeach
                <option value="all">Cả năm</option>
              </select>
            </div>

            <div class="col-md-3 col-sm-12 align-self-end mb-3">
              <button type="submit" class="btn btn-primary">Xem điểm</button>
            </div>

          </div>
        </form>

        <hr>

        {{-- Student result --}}
        @if (isset($classroom))

          {{-- Student rank --}}
          <div class="row">
            <div class="col-md-2 col-sm-12 mb-4">
              <label>ĐTB học kỳ</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $studentAverageSemester }}" readonly>
            </div>

            <div class="col-md-2 col-sm-12 mb-4">
              <label>Xếp loại học kỳ</label>
              <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $studentSemesterRank->name }}" readonly>
            </div>

            <div class="col-md-2 col-sm-12 mb-4 align-self-end">
              <a href="{{ route('exports.studentSemesterResult', ['student' => $student->id])."?year=".$query['year']."&semester=".$query['semester'] }}" class="mr-2">
                <button class="btn btn-primary btn-sm btn-icon-text">
                  <i class='fa-solid fa-file btn-icon-prepend'></i>Xuất kết quả học tập
                </button>
              </a>
            </div>
          </div>
        
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
        @endif
          

      </div>
    </div>
  </div>

</div>
@endsection
