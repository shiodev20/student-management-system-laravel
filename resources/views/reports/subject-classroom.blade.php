@extends('partials.layouts.main')

@section('documentTitle')
  Tổng Kết Điểm Môn Học Của Lớp
@endsection

@section('content')
<div class="row">

  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="card-title">Tổng kết điểm môn học của lớp</div>

        <form action="{{ route('reports.processSubjectClassroom') }}" method="POST" id="reportClassroomSubjectForm">
          @csrf

          <div class="row">
            {{-- Year --}}
            <div class="col-md-2 col-sm-12 mb-3">
              <label for="year">Năm học</label>
              <select class="form-control form-control-sm font-weight-bold" id="year" name="year" style="min-width: 100px;">
                <option value="">Lựa chọn</option>
                @foreach ($years as $year)
                  <option value="{{ $year->id }}">{{ $year->name }}</option>
                @endforeach
              </select>
              <div class="invalid-feedback year-error"></div>
            </div>

            {{-- Semester --}}
            <div class="col-md-2 col-sm-12 mb-3">
              <label for="semester">Học kỳ</label>
              <select class="form-control form-control-sm font-weight-bold" id="semester" name="semester" style="min-width: 100px;">
                <option value="">Lựa chọn</option>
                @foreach ($semesters as $semester)
                  <option value="{{ $semester->id }}">{{ $semester->name }}</option>
                @endforeach
              </select>

              <div class="invalid-feedback semester-error"></div>
            </div>

            {{-- Subject --}}
            <div class="col-md-2 col-sm-12 mb-3">
              <label for="subject">Môn học</label>
              <select class="form-control form-control-sm font-weight-bold" id="subject" name="subject" style="min-width: 100px;">
                <option value="">Lựa chọn</option>
                @foreach ($subjects as $subject)
                  <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
              </select>

              <div class="invalid-feedback subject-error"></div>
            </div>

            {{-- Classroom --}}
            <div class="col-md-2 col-sm-12 mb-3">
              <label for="classroom">Lớp học</label>
              <select class="form-control form-control-sm font-weight-bold" id="classroom" name="classroom" style="min-width: 100px;">
                <option value="">Lựa chọn</option>
                @foreach ($classrooms as $classroom)
                  <option value="{{ $classroom->id }}">{{ $classroom->year_id.' - '.$classroom->name }}</option>
                @endforeach
              </select>

              <div class="invalid-feedback classroom-error"></div>
            </div>
            
            <div id="submit-button" class="col-md-3 col-sm-12 align-self-end mb-3">
              <button type="submit" class="btn btn-primary">Báo cáo</button>
            </div>

          </div>

        </form>
        
        <hr>

        <div id="reportResult">

        </div>

      </div>
    </div>
  </div>
  
</div>
@endsection

@push('js')
<script>
  const reportForm = document.querySelector('#reportClassroomSubjectForm')

  reportForm.addEventListener('submit', (e) => {
    e.preventDefault()

    const data = {
      '_token': '{{ csrf_token() }}',
      'year': document.querySelector('select[name=year]').value,
      'semester': document.querySelector('select[name=semester]').value,
      'subject': document.querySelector('select[name=subject]').value,
      'classroom': document.querySelector('select[name=classroom]').value,
    }

    fetch("{{ route('reports.processSubjectClassroom') }}", {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Accept': 'application/json',
        'Content-type': 'application/json',
      },
    })
    .then((response) => response.json())
    .then((data) => {
      if(!data.status) {
        for (const message in data.messages) {
          document.querySelector(`#reportClassroomSubjectForm select[name=${message}]`).style.border =  '1px solid #dc3545';
          document.querySelector(`#reportClassroomSubjectForm .${message}-error`).style.display = 'block';
          document.querySelector(`#reportClassroomSubjectForm .${message}-error`).innerHTML = data.messages[message];
        }

        document.querySelector('#reportClassroomSubjectForm #submit-button').classList.add('align-self-center', 'mt-1');
      }
      else {
        const reportResult = document.querySelector('#reportResult');
  
        let markTypeheads = '';
        data.result.markTypes.forEach(markType => {
          markTypeheads += `<th>${markType.name}</th>`
        })

        let studentResults = '';
        data.result.studentMarks.forEach((student, idx) => {
          studentResults += `<tr>`;

          studentResults += `
            <th>${ idx + 1 }</th>
            <td class="font-weight-bold">${ student.id }</td>
            <td class="font-weight-bold">${ student.first_name }</td>
            <td class="font-weight-bold">${ student.last_name }</td>
          `;

          data.result.markTypes.forEach(markType => {
            student.marks.forEach(mark => {
              if(mark.mark_type_id == markType.id) {
                studentResults += `
                <td>
                  <input style="min-width: 60px; max-width: 100px;" class="form-control form-control-sm font-weight-bold text-center text-md-left" type="text" name="${markType.id}" value="${mark.mark.toFixed(1)}" readonly>
                </td>
                `;
              }
            })
          })

          studentResults += `</tr>`;
        })


        const tableHeader =  `
          <thead class="table-primary">
            <tr>
              <th>STT</th>
              <th>Mã học sinh</th>
              <th>Họ</th>
              <th>Tên</th>
              ${markTypeheads}
            </tr>
          </thead>
        `;

        const tableBody = `
          <tbody>
            ${studentResults}
          </tbody>
        `;

        reportResult.innerHTML = `
          <div class="table-responsive">
            <table class="table table-hover">
              ${tableHeader}
              ${tableBody}
            </table>
          </div>
        `;
      }
    })
   
  });
</script>
@endpush

@push('js')
<script>
  const selects = document.querySelectorAll('#reportClassroomSubjectForm select')

  selects.forEach(select => {
    select.addEventListener('change', () => {
      select.style.border = '1px solid #CED4DA'
      const invalidFeedBack = document.querySelector(`select[id=${select.id}] + .invalid-feedback`)
      if(invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
    })
  })
</script>
@endpush