@extends('pdf.wrapper')

@section('documentTitle')
  Danh sách học sinh lớp {{ $classroom->id }}
@endsection

@section('title')
  Danh sách học sinh lớp {{ $classroom->id }}
@endsection

@section('subtitle')
  Năm học: {{ $classroom->year->name }}
@endsection

@section('meta')
<table>
  <tr>
    <td>Mã lớp:</td>
    <td>{{ $classroom->id }}</td>
  </tr>
  <tr>
    <td>Tên lớp:</td>
    <td>{{ $classroom->name }}</td>
  </tr>
  <tr>
    <td>Khối lớp:</td>
    <td>{{ $classroom->grade->name }}</td>
  </tr>
  <tr>
    <td>Sĩ số:</td>
    <td>{{ $classroom->size }}</td>
  </tr>
  <tr>
    <td>Giáo viên chủ nhiệm:</td>
    <td>{{ $classroom->headTeacher ? $classroom->headTeacher->first_name . ' ' . $classroom->headTeacher->last_name : '' }}</td>
  </tr>
</table>
@endsection

@section('data')
<table>
  <thead>
    <tr>
      <th style="width: 10px;">STT</th>
      <th>MSHS</th>
      <th>Họ tên</th>
      <th>Ngày sinh</th>
      <th>Giới tính<div>(Nam)</div></th>
      <th>Ghi chú</th>
    </tr>
  </thead>

  <tbody>
    @foreach ($classroom->students as $student)
    <tr>
      <td>{{ $loop->index + 1 }}</td>
      <td>{{ $student->id }}</td>
      <td>{{ $student->first_name.' '.$student->last_name }}</td>
      <td>{{ date_format(date_create($student->dob), 'd/m/Y') }}</td>
      <td>{{ $student->gender ? 'Nam' : '' }}</td>
      <td></td>
    </tr>
    @endforeach

  </tbody>
</table>
@endsection
