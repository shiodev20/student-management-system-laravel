@extends('pdf.wrapper')

@section('documentTitle')
  Danh sách giáo viên bộ môn lớp {{ $classroom->id }}
@endsection

@section('title')
  Danh sách giáo viên bộ môn lớp {{ $classroom->id }} 
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
        <th>Môn học</th>
        <th>Họ tên giáo viên</th>
        <th>Giới tính<div>(Nam)</div></th>
        <th>Số điện thoại</th>
        <th>email</th>
        <th>Ghi chú</th>
      </tr>
    </thead>

    <tbody>
      @foreach ($subjectTeachers as $subject)
      <tr>
        <th>{{ $loop->index + 1 }}</th>
        <td>{{ $subject->name }}</td>

        @if ($subject->subjectTeacher)
          <td>{{ $subject->subjectTeacher->first_name.' '.$subject->subjectTeacher->last_name }}</td>
          <td>{{ $subject->subjectTeacher->gender ? 'Nam' : '' }}</td>
          <td>{{ $subject->subjectTeacher->phone }}</td>
          <td>{{ $subject->subjectTeacher->email }}</td>
          <td></td>
        @else
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        @endif

      </tr>  
      @endforeach
    </tbody>
  </table>  
@endsection