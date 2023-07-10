<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\MarkTypeContoller;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Models\Classroom;
use App\Models\Mark;
use App\Models\MarkType;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


require __DIR__.'/classroom.php';

Route::middleware(['guest'])->group(function () {
  Route::get('/login', [AuthController::class, 'create'])->name('login');
  Route::post('/login', [AuthController::class, 'store']);

  Route::get('/forgot-password', [ResetPasswordController::class, 'passwordResetRequest'])->name('password.request');
  Route::post('/forgot-password', [ResetPasswordController::class, 'passwordResetSendEmail'])->name('password.email');
  Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');
  Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');
});


Route::middleware(['auth'])->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');
  Route::get('/user/{id}', [UserController::class, 'show'])->name('users.show');
  Route::post('/user/{id}/changePassword', [UserController::class, 'updatePassword'])->name('users.updatePassword');

  Route::middleware(['staff'])->group(function() {
    Route::get('/students/search', [StudentController::class, 'search'])->name('students.search');
    Route::get('/students/{student}/yearResult', [StudentController::class, 'showYearResult'])->name('students.showYearResult');
    Route::resource('students', StudentController::class);

    Route::get('/reports/classroom', [ReportController::class, 'reportClassroom'])->name('reports.classroom');
    Route::post('/reports/classroom', [ReportController::class, 'processReportClassroom'])->name('reports.processClassroom');
    Route::get('/reports/subjectClassroom', [ReportController::class, 'reportSubjectClassroom'])->name('reports.subjectClassroom');
    Route::post('/reports/subjectClassroom', [ReportController::class, 'processReportSubjectClassroom'])->name('reports.processSubjectClassroom');
    Route::get('/reports/subject', [ReportController::class, 'reportSubject'])->name('reports.subject');
    Route::post('/reports/subject', [ReportController::class, 'processReportSubject'])->name('reports.processSubject');
    Route::get('/reports/semester', [ReportController::class, 'reportSemester'])->name('reports.semester');
    Route::post('/reports/semester', [ReportController::class, 'processReportSemester'])->name('reports.processSemester');
    Route::get('/reports/year', [ReportController::class, 'reportYear'])->name('reports.year');
    Route::post('/reports/year', [ReportController::class, 'processReportYear'])->name('reports.processYear');

    Route::get('/rules', [RuleController::class, 'index'])->name('rules.index');
    Route::put('/rules/update', [RuleController::class, 'update'])->name('rules.update');
    Route::get('/schoolYears', [SchoolYearController::class, 'index'])->name('schoolYears.index');
    Route::put('/schoolYears/update', [SchoolYearController::class, 'update'])->name('schoolYears.update');
    Route::get('/markTypes', [MarkTypeContoller::class, 'index'])->name('markTypes.index');
    Route::put('/markTypes/update', [MarkTypeContoller::class, 'update'])->name('markTypes.update');
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::put('/subjects/update', [SubjectController::class, 'update'])->name('subjects.update');

    Route::get('/exports/classrooms/{classroom}/exportStudentList', [ExportController::class, 'exportStudentList'])->name('exports.studentList');
    Route::get('/exports/classrooms/{classroom}/exportSubjectTeacherList', [ExportController::class, 'exportSubjectTeacherList'])->name('exports.subjectTeacherList'); 
    Route::get('/exports/students/{student}/exportStudentSemesterResult', [ExportController::class, 'exportStudentSemesterResult'])->name('exports.studentSemesterResult');
    Route::get('/exports/students/{student}/exportStudentYearResult', [ExportController::class, 'exportStudentYearResult'])->name('exports.studentYearResult');
  });

  Route::middleware(['teacher'])->group(function() {
    Route::get('/marks/{classroom}/edit', [MarkController::class, 'edit'])->name('marks.edit');
    Route::put('/marks/{classroom}', [MarkController::class, 'update'])->name('marks.update');
    Route::get('/marks/{classroom}/updateAverageMark', [MarkController::class, 'updateAverageMark'])->name('marks.updateAverageMark');

    Route::get('/{teacher}/headClassroom/{classroom}', function(Teacher $teacher, Classroom $classroom) {
      $currentYear = Year::getCurrentYear();

      if(($classroom->head_teacher_id != $teacher->id) || $classroom->year_id != $currentYear->id) {
        return response()->view('errors.403', [], 403);
      }
      
      $currentSemester = Semester::getCurrentSemester();
  
      $students = $classroom->students;
      $subjectTeachers = Teacher::getSubjectTeacherByClassroom($classroom->id);
      $headClassroom = $classroom;
  
      return view('classrooms.headClassrooms.show', compact([
        'classroom',
        'currentYear',
        'currentSemester',
        'students',
        'subjectTeachers',
        'headClassroom',
      ]));
    })->name('teachers.showHeadClassroom');
    
    Route::get('/{teacher}/headClassroom/{classroom}/{student}', function(Request $request, Teacher $teacher, Classroom $classroom, Student $student) {
      $currentYear = Year::getCurrentYear();

      if(($classroom->head_teacher_id != $teacher->id) || $classroom->year_id != $currentYear->id) {
        return response()->view('errors.403', [], 403);
      }
      
      $query['semester'] = $request->query('semester');
      
      $headClassroom = $classroom;
      $currentSemester = Semester::getCurrentSemester();
      $semesters = Semester::all();
      $markTypes = MarkType::all();
      $studentResult = Mark::getStudentResult($student->id, $classroom->year_id, $query['semester']);
  
      return view('classrooms.headClassrooms.student', compact([
        'headClassroom',
        'currentYear',
        'currentSemester',
        'semesters',
        'student',
        'query',
        'classroom',
        'markTypes',
        'studentResult',
      ]));
    })->name('teachers.showHeadClassroomStudent');
  });

});
