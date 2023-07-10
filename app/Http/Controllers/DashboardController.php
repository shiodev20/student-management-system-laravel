<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Employee;
use App\Models\Grade;
use App\Models\Mark;
use App\Models\MarkType;
use App\Models\Rank;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Year;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(Request $request)
  {
    try {
      $currentUser = $request->session()->get('currentUser');
      $currentYear = Year::getCurrentYear();
      $currentSemester = Semester::getCurrentSemester();

      
      switch ($currentUser['role']) {
        case 1:
          $studentCount = Student::all()->count();
          $classroomCount = Classroom::all()->count();
          $teacherCount = Teacher::all()->count();
          $employeeCount = Employee::all()->count();

          return view('dashboards.staff', compact([
            'currentYear',
            'currentSemester',
            'studentCount',
            'classroomCount',
            'teacherCount',
            'employeeCount',
          ]));

          break;

        case 2:
          $grades = Grade::all();
          $teachingClassrooms = Classroom::getClassroomsBySubjectTeacher($currentUser['id'], $currentYear->id);
          $headClassroom = Classroom
            ::where([
              ['classrooms.year_id', '=', $currentYear->id],
              ['classrooms.head_teacher_id', '=', $currentUser['id']],
            ])->first();

          return view('dashboards.teacher', compact([
            'currentYear',
            'currentSemester',
            'grades',
            'teachingClassrooms',
            'headClassroom'
          ]));

          break;
        case 3:

          $query = [
            'year' => $request->query('year') ? $request->query('year') : Year::getCurrentYear()->id,
            'semester' => $request->query('semester') ? $request->query('semester') : Semester::getCurrentSemester()->id
          ];

          $years = Year::all();
          $semesters = Semester::all();
          $student = Student::find($currentUser['id']);
          $classroom = Classroom::getClassroomByStudent($student->id, $query['year']);

          if($query['semester'] == 'all') {
            $studentResult = [];
            $studentAverageYear = null;
            $studentYearRank = null;

            if($classroom) {
              $studentResult = Mark::getStudentYearResult($student->id, $query['year']);
              $studentAverageYear = Mark::getAverageYear($query['year'], $classroom->id, $student->id);
              $studentYearRank = Rank::getRankByMark($studentAverageYear);
            }

            return view('dashboards.student', compact([
              'query',
              'years',
              'semesters',
              'student',
              'classroom',
              'studentResult',
              'studentAverageYear',
              'studentYearRank',
            ]));
          }

          $markTypes = MarkType::all();
          $studentResult = [];
          $studentAverageSemester = null;
          $studentSemesterRank = null;

          if ($classroom) {
            $studentResult = Mark::getStudentResult($student->id, $query['year'], $query['semester']);
            $studentAverageSemester = Mark::getAverageSemester($query['year'], $query['semester'], $classroom->id, $student->id);
            $studentSemesterRank = Rank::getRankByMark($studentAverageSemester);
          }

          return view('dashboards.student', compact([
            'query',
            'years',
            'semesters',
            'markTypes',
            'student',
            'classroom',
            'studentResult',
            'studentAverageSemester',
            'studentSemesterRank',
          ]));
          break;
      }

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }
}
