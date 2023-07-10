@extends('pdf.wrapper')

@section('documentTitle')
  Kết quả học tập học sinh {{ $student->id }}
@endsection

@section('title')
Kết quả học tập học sinh {{ $student->id }}
@endsection

@section('subtitle')
  Năm học: {{ $classroom->year->name }}
@endsection

@section('meta')
  <table>
    <tr>
      <td>MSHS:</td>
      <td>{{ $student->id }}</td>
    </tr>
    <tr>
      <td>Họ tên:</td>
      <td><b>{{ $student->first_name." ".$student->last_name  }}</b></td>
    </tr>
    <tr>
      <td>Lớp học:</td>
      <td>{{ $classroom->id }}</td>
    </tr>
    <tr>
      <td>Điểm trung bình cả năm:</td>
      <td><b>{{ $studentAverageYear }}</b></td>
    </tr>
    <tr>
      <td>Xếp loại cả năm:</td>
      <td><b>{{ $studentYearRank->name }}</b></td>
    </tr>
  </table>
@endsection

@section('data')
<table>

  <thead>
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
        <td>{{ $subject->name }}</td>
        
        @foreach ($subject->marks as $mark)
          <td>{{number_format($mark['mark'], 1) }}</td>
        @endforeach
      </tr>
    @endforeach
  </tbody>

</table>
@endsection
