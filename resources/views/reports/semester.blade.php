@extends('partials.layouts.main')

@section('documentTitle')
  Tổng kết học kỳ
@endsection

@section('content')
<div class="row">

  <div class="col">
    <div class="card">
      <div class="card-body">
        <div class="card-title">Tổng kết học kỳ</div>

        <form action="{{ route('reports.processSemester') }}" method="POST" id="reportSemesterForm">
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

            <div id="submit-button" class="col-md-3 col-sm-12 align-self-end mb-3" style="flex: 1;">
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
    const reportForm = document.querySelector('#reportSemesterForm')

  reportForm.addEventListener('submit', (e) => {
    e.preventDefault()

    const data = {
      '_token': '{{ csrf_token() }}',
      'year': document.querySelector('select[name=year]').value,
      'semester': document.querySelector('select[name=semester]').value,
    }

    fetch('{{ route('reports.semester') }}', {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Accept': 'application/json',
        'Content-type': 'application/json',
      },
    })
    .then(response => response.json())
    .then(data => {
      if(!data.status) {
        for (const message in data.messages) {
          document.querySelector(`#reportSemesterForm select[name=${message}]`).style.border =  '1px solid #dc3545';
          document.querySelector(`#reportSemesterForm .${message}-error`).style.display = 'block';
          document.querySelector(`#reportSemesterForm .${message}-error`).innerHTML = data.messages[message];
        }

        document.querySelector('#reportSemesterForm #submit-button').classList.add('align-self-center', 'mt-1');
      }
      else {
        const reportResult = document.querySelector('#reportResult');
        
        let tabItems = ``;
        data.result.grades.forEach((grade, idx) => {
          if(idx == 0) {
            tabItems += `
              <li class="nav-item">
                <a class="nav-link font-weight-bold active" data-toggle="tab" href="#${ grade.id }" role="tab">${ grade.name }</a>
              </li>
            `
          } else {
            tabItems += `
              <li class="nav-item">
                <a class="nav-link font-weight-bold" data-toggle="tab" href="#${ grade.id }" role="tab">${ grade.name }</a>
              </li>
            `
          }
        })

        const tabs = `
          <ul class="nav nav-tabs">
            ${tabItems}
          </ul>
        `;
        
        let paneItems = ``;
        data.result.grades.forEach((grade, idx) => {
          
          let report = ``;

          data.result.semesterReports[grade.id].forEach(classroom => {
            report += `
              <tr>
                <td class="font-weight-bold">${ classroom.id }</td>
                <td class="font-weight-bold">${ classroom.name }</td>
                <td class="font-weight-bold">${ classroom.size }</td>
                <td class="font-weight-bold">${ classroom.pass_quantity }</td>
                <td class="font-weight-bold">${ classroom.pass_ratio }</td>
              </tr>
            `;
          });

          paneItems += `
            <div class="tab-pane fade ${ idx == 0 ? 'active show' : '' } " id="${ grade.id }">
              <div class="table-responsive">

                <table class="table table-hover">

                  <thead class="table-primary">
                    <tr>
                      <th>Mã lớp</th>
                      <th>Tên lớp</th>
                      <th>Sỉ số</th>
                      <th>Số lượng đạt</th>
                      <th>Tỉ lệ (%)</th>
                    </tr>
                  </thead>

                  <tbody>
                    ${report}
                  </tbody>

                </table>

              </div>
            </div>
          
          `
        })

        const panes = `
          <div class="tab-content">
            ${ paneItems }
          </div>
        `;

        reportResult.innerHTML = `
          ${tabs}
          ${panes}
        `;
        
      }
    })

  })
  </script>
@endpush

@push('js')
<script>
  const selects = document.querySelectorAll('#reportSemesterForm select')

  selects.forEach(select => {
    select.addEventListener('change', () => {
      select.style.border = '1px solid #CED4DA'
      const invalidFeedBack = document.querySelector(`select[id=${select.id}] + .invalid-feedback`)
      if(invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
    })
  })
</script>
@endpush