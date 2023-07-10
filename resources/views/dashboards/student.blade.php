@extends('partials.layouts.main')

@section('documentTitle')
  Trang chủ
@endsection

@section('content')
{{-- <div class="row">
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
              <a href="{{ route('teachers.showHeadClassroom', ['teacher' => $currentUser['id'], 'classroom' => $headClassroom->id]) }}" class="btn btn-primary btn-sm">Lớp chủ nhiệm</a>
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
</div> --}}

<div class="row">
  {{-- <div class="col-12 grid-margin">
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
  </div> --}}

  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">

        <div class="card-title">Kết quả học tập</div>

        {{-- Student result searching --}}
        <form action="{{route('dashboard')}}" method="GET" id="studentResultForm">
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

                @if ($query['semester'] == 'all')

                  @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                  @endforeach
                  <option value="all" selected>Cả năm</option>

                @else

                  @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}" {{ $query['semester'] == $semester->id ? 'selected' : '' }}>{{ $semester->name }}</option>
                  @endforeach
                  <option value="all">Cả năm</option>
                  
                @endif
                
              </select>
            </div>

            <div class="col-md-3 col-sm-12 align-self-end mb-3">
              <button type="submit" class="btn btn-primary">Xem điểm</button>
            </div>

          </div>
        </form>

        <hr>


        @if (isset($classroom))

          @if ($query['semester'] == 'all')
            <div class="row">
              <div class="col-md-2 col-sm-12 mb-4">
                <label>ĐTB cả năm</label>
                <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $studentAverageYear }}" readonly>
              </div>
    
              <div class="col-md-2 col-sm-12 mb-4">
                <label>Xếp loại cả năm</label>
                <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $studentYearRank->name }}" readonly>
              </div>
    
            </div>

            <div class="table-responsive">
              <table class="table table-hover">
  
                <thead class="table-primary">
                  <tr>
                    <th>STT</th>
                    <th>Môn học</th>
                    @foreach ($semesters as $semester)
                    <th>{{ $semester->name }}</th>
                    @endforeach
                    <th>Cả năm</th>
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
                            value="{{ number_format($mark['mark'], 1) }}"
                            readonly>
                        </td>
                      @endforeach
                    </tr>
                  @endforeach
                </tbody>
  
              </table>
            </div>
          @else
            <div class="row">
              <div class="col-md-2 col-sm-12 mb-4">
                <label>ĐTB học kỳ</label>
                <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $studentAverageSemester }}" readonly>
              </div>

              <div class="col-md-2 col-sm-12 mb-4">
                <label>Xếp loại học kỳ</label>
                <input type="text" class="form-control form-control-sm font-weight-bold" value="{{ $studentSemesterRank->name }}" readonly>
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
            
        @endif
          
      </div>
    </div>
  </div>

</div>
@endsection

@push('js')
{{-- <script>
  const studentResultForm = document.querySelector('#studentResultForm')
  
  studentResultForm.addEventListener('submit', (e) => {
  e.preventDefault()

  const data = {
    '_token': '{{ csrf_token() }}',
    'year': document.querySelector('select[name=year]').value,
    'semester': document.querySelector('select[name=semester]').value,
  }

  fetch('{{ route('api.studentResult', ['student' => $student->id]) }}', {
    method: 'POST',
    body: JSON.stringify(data),
    headers: {
      'Accept': 'application/json',
      'Content-type': 'application/json',
    },
  })
  .then(response => response.json())
  .then(data => {
    console.log(data);

    // if(!data.status) {
    //   for (const message in data.messages) {
    //     document.querySelector(`#reportYearForm select[name=${message}]`).style.border =  '1px solid #dc3545';
    //     document.querySelector(`#reportYearForm .${message}-error`).style.display = 'block';
    //     document.querySelector(`#reportYearForm .${message}-error`).innerHTML = data.messages[message];
    //   }

    //   document.querySelector('#reportYearForm #submit-button').classList.add('align-self-center', 'mt-1');
    // }
    // else {
    //   const reportResult = document.querySelector('#reportResult');
      
    //   let tabItems = ``;
    //   data.result.grades.forEach((grade, idx) => {
    //     if(idx == 0) {
    //       tabItems += `
    //         <li class="nav-item">
    //           <a class="nav-link font-weight-bold active" data-toggle="tab" href="#${ grade.id }" role="tab">${ grade.name }</a>
    //         </li>
    //       `
    //     } else {
    //       tabItems += `
    //         <li class="nav-item">
    //           <a class="nav-link font-weight-bold" data-toggle="tab" href="#${ grade.id }" role="tab">${ grade.name }</a>
    //         </li>
    //       `
    //     }
    //   })

    //   const tabs = `
    //     <ul class="nav nav-tabs">
    //       ${tabItems}
    //     </ul>
    //   `;
      
    //   let paneItems = ``;
    //   data.result.grades.forEach((grade, idx) => {
        
    //     let report = ``;

    //     data.result.yearReports[grade.id].forEach(classroom => {
    //       report += `
    //         <tr>
    //           <td class="font-weight-bold">${ classroom.id }</td>
    //           <td class="font-weight-bold">${ classroom.name }</td>
    //           <td class="font-weight-bold">${ classroom.size }</td>
    //           <td class="font-weight-bold">${ classroom.pass_quantity }</td>
    //           <td class="font-weight-bold">${ classroom.pass_ratio }</td>
    //         </tr>
    //       `;
    //     });

    //     paneItems += `
    //       <div class="tab-pane fade ${ idx == 0 ? 'active show' : '' } " id="${ grade.id }">
    //         <div class="table-responsive">

    //           <table class="table table-hover">

    //             <thead class="table-primary">
    //               <tr>
    //                 <th>Mã lớp</th>
    //                 <th>Tên lớp</th>
    //                 <th>Sỉ số</th>
    //                 <th>Số lượng đạt</th>
    //                 <th>Tỉ lệ (%)</th>
    //               </tr>
    //             </thead>

    //             <tbody>
    //               ${report}
    //             </tbody>

    //           </table>

    //         </div>
    //       </div>
        
    //     `
    //   })

    //   const panes = `
    //     <div class="tab-content">
    //       ${ paneItems }
    //     </div>
    //   `;

    //   reportResult.innerHTML = `
    //     ${tabs}
    //     ${panes}
    //   `;
      
    // }
  })

})
</script> --}}


@endpush