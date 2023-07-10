<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Classroom extends Model
{
  use HasFactory;
  
  public $timestamps = false;
  public $incrementing = false;
  protected $fillable = [
    'id',
    'name',
    'size',
    'grade_id',
    'year_id',
    'head_teacher_id',
  ];

  // Relationship
  public function grade(): BelongsTo {
    return $this->belongsTo(Grade::class, 'grade_id', 'id');
  }

  public function year(): BelongsTo {
    return $this->belongsTo(Year::class, 'year_id', 'id');
  }

  public function headTeacher(): BelongsTo {
    return $this->belongsTo(Teacher::class, 'head_teacher_id', 'id');
  }

  public function students(): BelongsToMany {
    return $this->belongsToMany(Student::class, 'classroom_details');
  }

  
  // Custom query function
  public static function getClassroomByStudent($student, $year) {
    return self::
      join('classroom_details', 'classrooms.id', '=', 'classroom_details.classroom_id')
      ->join('students', 'students.id', '=', 'classroom_details.student_id')
      ->where([
          ['classrooms.year_id', '=', $year],
          ['students.id', '=', $student]
        ])
      ->select('classrooms.*')
      ->first();
  }

  public static function getClassroomByYear($year) {
    return self::where('year_id', '=', $year)->get();
  }

  public static function getClassroomsBySubjectTeacher($teacher, $year) {

    $classrooms = Classroom
      ::join('teaching_assignments', 'classrooms.id', '=', 'teaching_assignments.classroom_id')
      ->where([
        ['classrooms.year_id', '=', $year],
        ['teaching_assignments.subject_teacher_id', '=', $teacher]
      ])->select('classrooms.*')->get();
    
    return $classrooms;
  }

  public static function addClassrooms($year, $grade, $quantity) {
    $createdClassrooms = Classroom::where([
      ['year_id', '=', $year],
      ['grade_id', '=', $grade]
    ])
    ->select('id')->get();

    $yearPosfix = substr($year, 2);
    $gradePosfix = substr($grade, 2);
    
    $classrooms = [];
    $teachingAssignments = [];

    $subjects = Subject::all();
    $count = 0;
    $classIndex = 1;

    while ($count < $quantity) {
      $isContain = false;
      $classroomId = $gradePosfix.'A'.$classIndex.$yearPosfix;

      foreach ($createdClassrooms as $classroom) {
        if($classroom->id == $classroomId) $isContain = true;
      }

      if($isContain) {
        $classIndex++;
        continue;
      }
      else {
        array_push($classrooms, [
          'id' => $classroomId,
          'name' =>  $gradePosfix.'A'.$classIndex,
          'grade_id' => $grade,
          'year_id' => $year,
        ]);
      }

      $count++;
      $classIndex++;
    }

    foreach ($classrooms as $classroom) {
      foreach ($subjects as $subject) {
        $teachingAssignment = [
          'classroom_id' => $classroom['id'],
          'subject_id' => $subject->id,
        ];      

        array_push($teachingAssignments, $teachingAssignment);
      }
    }

    Classroom::insert($classrooms);
    TeachingAssignment::insert($teachingAssignments);
  }

  public static function addStudentsToClassroom($classroom, $students) {

    $semesters = Semester::all();
    $markTypes = MarkType::all();
    $subjects = Subject::all();

    $marks = [];
    $classroomAssigns = [];

    foreach ($students as $student) {

      $classroomAssign = [
        'student_id' => $student,
        'classroom_id' => $classroom->id,
      ];

      array_push($classroomAssigns, $classroomAssign);

      foreach ($semesters as $semester) {
        foreach ($markTypes as $markType) {
          foreach ($subjects as $subject) {
            $mark = [
              'year_id' => $classroom->year_id,
              'semester_id' => $semester->id,
              'classroom_id' => $classroom->id,
              'subject_id' => $subject->id,
              'student_id' => $student,
              'mark_type_id' => $markType->id,
              'mark' => 0.0
            ];

            array_push($marks, $mark);
          }
        }
      }
      
    }

    ClassroomDetail::insert($classroomAssigns);

    $classroom->update([
      'size' => $classroom->size + count($students),
    ]);

    Mark::insert($marks);
    
    return true;
  }

  public static function addHeadTeacherToClassroom($classroom, $teacher) {
    
    // Lớp học đã có giáo viên chủ nhiệm
    if($classroom->head_teacher_id) {
      $oldHeadTeacher = Teacher::find($classroom->head_teacher_id);
      $oldTeachingAssignment = TeachingAssignment::where([
        ['classroom_id', '=', $classroom->id],
        ['subject_id', '=', $oldHeadTeacher->subject->id]
      ])->first();

      $oldTeachingAssignment->update([ 'subject_teacher_id' => null ]);
    }

    $newHeadTeacher = Teacher::find($teacher);

    $newTeachingAssignment = TeachingAssignment::where([
      ['classroom_id', '=', $classroom->id],
      ['subject_id', '=', $newHeadTeacher->subject->id]
    ])->first();

    $newTeachingAssignment->update([ 'subject_teacher_id' => $newHeadTeacher->id ]);
    $classroom->update([ 'head_teacher_id' => $newHeadTeacher->id ]);

    return true;

  }

  public static function addSubjectTeachersToClassroom($classroom, $assignments) {

    foreach ($assignments as $assignment) {
      $teachingAssignment = TeachingAssignment::where([
        ['classroom_id', '=', $classroom],
        ['subject_id', '=', $assignment['subjectId']]
      ])->first();
  
      $teachingAssignment->update([ 'subject_teacher_id' => $assignment['subjectTeacherId'] ]);
    }

    return true;
  }
}
