<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
  use HasFactory;

  public $timestamps = false;
  public $incrementing = false;
  
  protected $fillable = [
    'id',
    'first_name',
    'last_name',
    'gender',
    'dob',
    'address',
    'email',
    'parent_name',
    'parent_phone',
    'enroll_date',
    'account_id',
    'role_id',
  ];

  public function marks(): HasMany
  {
    return $this->hasMany(Mark::class, 'student_id', 'id');
  }

  public function classrooms(): BelongsToMany
  {
    return $this->belongsToMany(Classroom::class, 'classroom_details');
  }

  public function role(): BelongsTo {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }

  public function account(): BelongsTo {
    return $this->belongsTo(Account::class, 'account_id', 'id');
  }

  public static function getNoClassroomAssignmentStudents($classroom) {

    $students = [];

    $gradeNumber = substr($classroom->grade_id, 2) - 1;

    if($gradeNumber < 10) {
      $classroomAssignedStudent = ClassroomDetail::select('student_id')->get();
      $students = Student::where('status', '=', 1)->whereNotIn('id', $classroomAssignedStudent);
    } 
    else {
      $splitYear = str_split($classroom->year_id, 2);

      $previousYear = $splitYear[0].($splitYear[1] - 1).($splitYear[2] - 1);
      $previousGrade = 'KH'.$gradeNumber;


      $assignedStudents = Student
      ::join('classroom_details', 'students.id', '=', 'classroom_details.student_id')
      ->join('classrooms', 'classrooms.id', '=', 'classroom_details.classroom_id')
      ->where([
        ['classrooms.year_id', '=', $classroom->year_id],
        ['classrooms.grade_id', '=', $classroom->grade_id],
      ])->select('students.id')->get();


      $students = Student
      ::join('classroom_details', 'students.id', '=', 'classroom_details.student_id')
      ->join('classrooms', 'classrooms.id', '=', 'classroom_details.classroom_id')
      ->where([
        ['classrooms.year_id', '=', $previousYear],
        ['classrooms.grade_id', '=', $previousGrade],
        ['students.status', '=', 1]
      ])
      ->whereNotIn('students.id', $assignedStudents)
      ->select('students.*', 'classrooms.name as class_name');
    }

    return $students;
  }
}
