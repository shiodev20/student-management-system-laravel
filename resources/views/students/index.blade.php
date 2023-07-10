@extends('partials.layouts.main')

@section('documentTitle')
  Quản lý học sinh
@endsection

@section('content')
  <div class="row">

    <div class="col-12 mb-4">
      <div class="card">
        <div class="card-body">

          <div class="d-flex justify-content-between align-items-center flex-wrap">

            {{-- Search form --}}
            <form action="{{ route('students.search') }}" method="GET" id="searchStudentForm">

              <div class="form-group row">
                {{-- Search info --}}
                <div class="col-md-4 col-sm-12 mb-2">

                  <label class="font-weight-bold" for="search_info">Thông tin</label>
                  <input 
                    type="text" id="search_info" class="form-control form-control-sm font-weight-bold"
                    name="search_info" 
                    style="{{ $errors->has('search_info') ? 'border: 1px solid #dc3545' : '' }}"
                    value="{{ old('search_info') ? old('search_info') : session('search_info') }}"
                  >

                  @error('search_info')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror

                </div>

                {{-- Search type --}}
                <div class="col-md-4 col-sm-12 mb-2">

                  <label class="font-weight-bold" for="search_type">Loại tìm kiếm</label>
                  <select 
                    style="{{ $errors->has('search_type') ? 'border: 1px solid #dc3545' : '' }}"
                    class="form-control form-control-sm font-weight-bold" id="search_type" name="search_type"
                  >
                    @switch(old('search_type') ? old('search_type') : session('search_type'))
                      @case('student_id')
                        <option value="">Lựa chọn</option>
                        <option value="student_id" selected>Mã học sinh</option>
                        <option value="student_name">Tên học sinh</option>
                      @break

                      @case('student_name')
                        <option value="">Lựa chọn</option>
                        <option value="student_id">Mã học sinh</option>
                        <option value="student_name" selected>Tên học sinh</option>
                      @break

                      @default
                        <option value="" selected>Lựa chọn</option>
                        <option value="student_id">Mã học sinh</option>
                        <option value="student_name">Tên học sinh</option>
                    @endswitch
                  </select>

                  @error('search_type')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror

                </div>

                {{-- Search button --}}
                <div
                  id="searchStudentButton"
                  class="col-md-4 col-sm-12 {{ $errors->has('search_info') || $errors->has('search_type') ? 'align-self-center mb-3' : 'align-self-end mb-2' }}">
                  <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>

              </div>

            </form>

            <div class="w-100 d-block d-md-none">
              <hr>
            </div>

            <div style="{{ $errors->has('search_info') || $errors->has('search_type') ? 'margin-bottom: 2.5rem' : '' }}">

              <a href="{{ route('students.create') }}" class="button is-primary">
                <button class="btn btn-primary btn-icon-text">
                  <i class='fa-solid fa-user-plus btn-icon-prepend'></i>Tiếp nhận học sinh
                </button>
              </a>

            </div>

          </div>

        </div>
      </div>
    </div>

    <div class="col-12">

      <div class="card">
        <div class="card-body">

          <div class="mb-4">
            <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm">Tất cả</a>
          </div>

          <div class="table-responsive">
            <table id="data" class="table table-hover table-striped">

              <thead class="table-primary">
                <tr>
                  <th>STT</th>
                  <th>Mã học sinh</th>
                  <th>Họ</th>
                  <th>Tên</th>
                  <th>Ngày sinh</th>
                  <th>Giới tính</th>
                  <th>Số điện thoại</th>
                  <th>Tình trạng</th>
                  <th>Lựa chọn</th>
                </tr>
              </thead>

              <tbody>

                @foreach ($students as $student)
                  <tr>
                    <td class="font-weight-bold">{{ $loop->index + 1 }}</td>
                    <td class="font-weight-bold">{{ $student->id }}</td>
                    <td class="font-weight-bold">{{ $student->first_name }}</td>
                    <td class="font-weight-bold">{{ $student->last_name }}</td>
                    <td class="font-weight-bold">{{ date_format(date_create($student->dob), 'd-m-Y') }}</td>
                    <td class="font-weight-bold">{{ $student->gender ? 'Nam' : 'Nữ' }}</td>
                    <td class="font-weight-bold">{{ $student->parent_phone }}</td>
                    <td class="font-weight-bold">{{ $student->status ? 'Còn học' : 'Thôi học' }}</td>
                    <td class="font-weight-bold">
                      <div class="d-flex justify-content-start">
                        <a 
                          class="mr-1"
                          href="{{ route('students.show', ['student' => $student->id])."?year=$currentYear->id&semester=$currentSemester->id" }}">
                          <button class="btn btn-sm btn-info">
                            <i class='fa-solid fa-chart-simple' style="font-size: .8rem;"></i>
                          </button>
                        </a>

                        @if ($student->status)

                          <a href="{{ route('students.edit', ['student' => $student->id]) }}" class="mr-1">
                            <button class="btn btn-sm btn-success">
                              <i class='fa-solid fa-pen' style="font-size: .8rem;"></i>
                            </button>
                          </a>

                          <x-delete-confirm-button
                            :url="route('students.destroy', ['student' => $student->id])"
                            :message="'học sinh '.$student->id"
                          ><i class='fa-solid fa-trash' style="font-size: .8rem;"></i></x-delete-confirm-button>

                        @else
                          <button class="btn btn-sm btn-success mr-1" disabled><i class='fa-solid fa-pen' style="font-size: .8rem;"></i></button>
                          <button class="btn btn-sm btn-danger" disabled><i class='fa-solid fa-trash' style="font-size: .8rem;"></i></button>
                        @endif
                      </div>
                    </td>
                  </tr>
                @endforeach

              </tbody>

            </table>
          </div>
          
          <div class="mt-4 d-flex justify-content-center justify-content-md-end ">
            {{ $students->links() }}
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection

@push('js')
<script>
  const inputs = document.querySelectorAll('#searchStudentForm input')
  const selects = document.querySelectorAll('#searchStudentForm select')

  inputs.forEach(input => {
    input.addEventListener('input', () => {
      input.style.border = '1px solid #CED4DA'
      const invalidFeedBack = document.querySelector(`input[id=${input.id}] + .invalid-feedback`)
      if(invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
    })
  })

  selects.forEach(select => {
    select.addEventListener('change', () => {
      select.style.border = '1px solid #CED4DA'
      const invalidFeedBack = document.querySelector(`select[id=${select.id}] + .invalid-feedback`)
      if(invalidFeedBack) invalidFeedBack.style.visibility = 'hidden'
    })
  })
</script>
@endpush