<?php

use App\Http\Controllers\ClassroomController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'staff'])->group(function () {

  Route::get('/classrooms/search', [ClassroomController::class, 'search'])->name('classrooms.search');
  Route::get('/classrooms/{classroom}/assignStudent', [ClassroomController::class, 'assignStudent'])->name('classrooms.assignStudent');
  Route::get('/classrooms/{classroom}/assignHeadTeacher', [ClassroomController::class, 'assignHeadTeacher'])->name('classrooms.assignHeadTeacher');
  Route::get('/classrooms/{classroom}/assignSubjectTeacher', [ClassroomController::class, 'assignSubjectTeacher'])->name('classrooms.assignSubjectTeacher');
  Route::post('/classrooms/{classroom}/assignStudent', [ClassroomController::class, 'processAssignStudent'])->name('classrooms.processAssignStudent');
  Route::put('/classrooms/{classroom}/assignHeadTeacher', [ClassroomController::class, 'processAssignHeadTeacher'])->name('classrooms.processAssignHeadTeacher');
  Route::put('/classrooms/{classroom}/assignSubjectTeacher', [ClassroomController::class, 'processAssignSubjectTeacher'])->name('classrooms.processAssignSubjectTeacher');

  Route::delete('/classrooms/{classroom}', [ClassroomController::class, 'destroy'])->name('classrooms.destroy');
  Route::delete('/classrooms/{classroom}/deleteHeadTeacher', [ClassroomController::class, 'deleteHeadTeacher'])->name('classrooms.deleteHeadTeacher');
  Route::delete('/classrooms/{classroom}/deleteStudent/{student}', [ClassroomController::class, 'deleteStudent'])->name('classrooms.deleteStudent');
  Route::delete('/classrooms/{classroom}/deleteAllStudents', [ClassroomController::class, 'deleteAllStudents'])->name('classrooms.deleteAllStudents');
  Route::delete('/classrooms/{classroom}/deleteSubjectTeacher/{teacher}', [ClassroomController::class, 'deleteSubjectTeacher'])->name('classrooms.deleteSubjectTeacher');
  Route::delete('/classrooms/{classroom}/deleteAllSubjectTeachers', [ClassroomController::class, 'deleteAllSubjectTeachers'])->name('classrooms.deleteAllSubjectTeachers');
  
  Route::resource('classrooms', ClassroomController::class);
});
