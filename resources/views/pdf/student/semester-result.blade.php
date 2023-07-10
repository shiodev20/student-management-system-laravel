@extends('pdf.wrapper')

@section('documentTitle')
  Kết quả học tập học sinh {{ $student->id }}
@endsection

@section('title')
Kết quả học tập học sinh {{ $student->id }}
@endsection

@section('subtitle')
  Năm học: {{ $classroom->year->name }} - Học kỳ: {{ $query['semester'] }}
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
      <td>Điểm trung bình học kỳ:</td>
      <td><b>{{ $studentAverageSemester }}</b></td>
    </tr>
    <tr>
      <td>Xếp loại học kỳ:</td>
      <td><b>{{ $studentSemesterRank->name }}</b></td>
    </tr>
  </table>
@endsection

@section('data')
<table>
  <thead>
    <tr>
      <th style="width: 10px;">STT</th>
      <th>Môn học</th>
      @foreach ($markTypes as $markType)
      <th style="width: 70px;">{{ $markType->name }}</th>
      @endforeach
    </tr>
  </thead>
  
  <tbody>
    @foreach ($studentResult as $subject)
      <tr>
        <td>{{ $loop->index + 1 }}</td>
        <td>{{ $subject->name }}</td>
        @foreach ($subject->marks as $mark)
          <td>{{ number_format($mark->mark, 1) }}</td>
        @endforeach
      </tr>
    @endforeach
  </tbody>

</table>
@endsection
