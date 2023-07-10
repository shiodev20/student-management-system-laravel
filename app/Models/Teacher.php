<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
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
    'phone',
    'account_id',
    'role_id',
    'subject_id',
  ];

  public function headingClassrooms(): HasMany {
    return $this->hasMany(Classroom::class, 'head_teacher_id', 'id');
  }

  public function account(): BelongsTo {
    return $this->belongsTo(Account::class, 'account_id', 'id');
  }

  public function role(): BelongsTo {
    return $this->belongsTo(Role::class, 'role_id', 'id');
  }

  public function subject(): BelongsTo {
    return $this->belongsTo(Subject::class, 'subject_id', 'id');
  }

  public static function getSubjectTeacherByClassroom($classroomId) {
    $teachingAssignments = TeachingAssignment::where('classroom_id', '=', $classroomId)->get();

    $subjectTeachers = [];

    foreach ($teachingAssignments as $teachingAssignment) {
      $subject = $teachingAssignment->subject;
      $subject['subjectTeacher'] = $teachingAssignment->subjectTeacher;

      array_push($subjectTeachers, $subject);
    }

    return $subjectTeachers;
  }

  public static function getNoAssignmentHeadTeacher() {

    $currentYear = Year::getCurrentYear();

    $assignedHeadTeacher = Teacher
    ::join('classrooms', 'teachers.id', '=', 'classrooms.head_teacher_id')
    ->where([
      ['head_teacher_id', '<>', 'null'],
      ['year_id', '=', $currentYear->id]
    ])->select('teachers.id')->get();


    $noAssignHeadTeachers = Teacher::whereNotIn('id', $assignedHeadTeacher)->paginate(10);

    return $noAssignHeadTeachers;
  }
}
