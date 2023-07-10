@extends('partials.layouts.main')

@section('documentTitle')
  Quản lý lớp học
@endsection

@section('content')
<div class="row">
        
  <div class="col-12 grid-margin">

    <div class="card">
      <div class="card-body">
        
        <div class="d-flex justify-content-between align-items-center flex-wrap">

          {{-- Classroom search --}}
          <div class="flex-grow-1">

            <form action="{{ route('classrooms.search') }}" method="GET">
              <div class="form-group row">

                <div class="col-md-3 col-sm-12 mb-2">
                  <label class="font-weight-bold" for="year">Năm học</label>
                  <select class="form-control form-control-sm font-weight-bold" id="year" name="year">
                    @foreach ($years as $year)
                      @if ($year->id == $selectedYear)
                        <option selected value="{{ $year->id }}">{{ $year->name }}</option>
                      @else
                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>

                <div class="col-md-6 col-sm-12 align-self-end mb-2">
                  <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                </div>

              </div>

            </form>

          </div>

          <div class="w-100 d-block d-md-none">
            <hr>
          </div>

          {{-- Classroom add button --}}
          <div class="flex-grow-1 text-right">
            <a href="{{ route('classrooms.create') }}" class="button is-primary">
              <button class="btn btn-primary btn-icon-text">
                <i class='fa-solid fa-plus btn-icon-prepend'></i>Mở lớp học
              </button>
            </a>
          </div>

        </div>

      </div>
    </div>

  </div>

  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="card-title">Danh sách lớp học</div>

        <a href="{{ route('classrooms.index') }}" class="btn btn-primary btn-sm mb-3">Năm học hiện tại</a>

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
                      <th>STT</th>
                      <th>Mã lớp</th>
                      <th>Năm học</th>
                      <th>Tên lớp</th>
                      <th>Sỉ số</th>
                      <th>Giáo viên chủ nhiệm</th>
                      <th>Lựa chọn</th>
                    </tr>
                  </thead>

                  <tbody>
                    @foreach ($classrooms as $classroom)
                      @if ($classroom->grade_id == $grade->id)
                      <tr>
                        <th>{{ $loop->index + 1 }}</th>
                        <td class="font-weight-bold">{{ $classroom->id }}</td>
                        <td class="font-weight-bold">{{ $classroom->year_id }}</td>
                        <td class="font-weight-bold">{{ $classroom->name }}</td>
                        <td class="font-weight-bold">{{ $classroom->size }}</td>
                        <td class="font-weight-bold">{{ $classroom->headTeacher ? $classroom->headTeacher->first_name.' '.$classroom->headTeacher->last_name  : '' }}</td>
                        <td>
                          <div class="d-flex justify-content-start">
                            <a href="{{ route('classrooms.show', [ 'classroom' => $classroom->id ]) }}" class="mr-2">
                              <button class="btn btn-info btn-sm"><i class='fa-solid fa-chart-simple' style="font-size: 0.8rem;"></i></button>
                            </a>

                            @if ($classroom->year_id == $currentYear->id)
                              <x-delete-confirm-button
                                :url="route('classrooms.destroy', ['classroom' => $classroom->id])"
                                :message="'Lớp học '.$classroom->id"
                              >
                                <i class='fa-solid fa-trash' style="font-size: .8rem;"></i>
                              </x-delete-confirm-button>
                            @else
                              <button class="btn btn-danger btn-sm" disabled><i class='fa-solid fa-trash' style="font-size: 0.8rem;"></i></button>
                            @endif
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
@endsection