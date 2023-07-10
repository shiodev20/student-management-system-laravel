<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Mark;
use App\Models\MarkType;
use App\Models\Rank;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller {
  public function exportStudentList(Classroom $classroom) {
    try {

      $pdf = Pdf::loadView('pdf.classroom.student-list', compact('classroom'));
      return $pdf->stream( "danh_sach_hoc_sinh_$classroom->id.pdf" )->header('Content-Type','application/pdf');
      
    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function exportSubjectTeacherList(Classroom $classroom) {
    try {
      $subjectTeachers = Teacher::getSubjectTeacherByClassroom($classroom->id);
  
      $pdf = Pdf::loadView('pdf.classroom.subjectTeacher-list', compact(['classroom', 'subjectTeachers']));
      return $pdf->stream("danh_sach_giao_vien_bo_mon_$classroom->id.pdf")->header('Content-Type', 'application/pdf');
      
    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function exportStudentSemesterResult(Request $request, Student $student) {

    try {
      $query = [
        'year' => $request->query('year'),
        'semester' => $request->query('semester')
      ];
  
      $markTypes = MarkType::all();
      $classroom = Classroom::getClassroomByStudent($student->id, $query['year']);
      $studentResult = Mark::getStudentResult($student->id, $query['year'], $query['semester']);
      $studentAverageSemester = Mark::getAverageSemester($query['year'], $query['semester'], $classroom->id, $student->id);
      $studentSemesterRank = Rank::getRankByMark($studentAverageSemester);
  
      $pdf = Pdf::loadView('pdf.student.semester-result', compact([
        'query',
        'student',
        'classroom',
        'markTypes',
        'studentResult',
        'studentAverageSemester',
        'studentSemesterRank',
      ]));
  
      return $pdf->stream("ket_qua_hoc_tap_".$student->id."_".$query['year']."_".$query['semester'].".pdf")->header('Content-Type', 'application/pdf');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    
  }

  public function exportStudentYearResult(Request $request, Student $student) {
    try {
      $query['year'] = $request->query('year');

      $semesters = Semester::all();
      $classroom = Classroom::getClassroomByStudent($student->id, $query['year']);
      $studentResult = Mark::getStudentYearResult($student->id, $query['year']);
      $studentAverageYear = Mark::getAverageYear($query['year'], $classroom->id, $student->id);
      $studentYearRank = Rank::getRankByMark($studentAverageYear);

      $pdf = Pdf::loadView('pdf.student.year-result', compact([
        'query',
        'student',
        'classroom',
        'semesters', 
        'studentResult',
        'studentAverageYear',
        'studentYearRank',
      ]));

      return $pdf->stream("ket_qua_hoc_tap_".$student->id."_".$query['year'].".pdf")->header('Content-Type', 'application/pdf');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    
  }
}
