<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mark extends Model
{
  use HasFactory;

  public $timestamps = false;
  protected $fillable = [
    'id',
    'year_id',
    'semester_id',
    'classroom_id',
    'subject_id',
    'student_id',
    'mark_type_id',
    'mark'
  ];

  public function year(): BelongsTo { return $this->belongsTo(Year::class, 'year_id', 'id'); }
  public function semester(): BelongsTo { return $this->belongsTo(Semester::class, 'semester_id', 'id'); }
  public function classroom(): BelongsTo { return $this->belongsTo(Classroom::class, 'classroom_id', 'id'); }
  public function subject(): BelongsTo { return $this->belongsTo(Subject::class, 'subject_id', 'id'); }
  public function student(): BelongsTo { return $this->belongsTo(Student::class, 'student_id', 'id'); }
  public function markType(): BelongsTo { return $this->belongsTo(MarkType::class, 'mark_type_id', 'id'); }


  public static function getMarksOfClassroomBySubject($classroom, $subject, $year, $semester) {

    $students = $classroom->students;

    $classroomMarks = Student
      ::join('marks', 'students.id', '=', 'marks.student_id')
      ->where([
        ['marks.year_id', '=', $year],
        ['Marks.semester_id', '=', $semester],
        ['marks.classroom_id', '=', $classroom->id],
        ['marks.subject_id', '=', $subject],
      ])->select('marks.*')->get();
    
    foreach ($students as $student) {

      $studentMarks = [];

      foreach ($classroomMarks as $mark) {
        if($mark->student_id == $student->id) array_push($studentMarks, $mark);
      }

      $student['marks'] = $studentMarks;
    }

    return $students;
  }

  public static function getStudentResult($student, $year, $semester) {
    $queryResult = Subject::join('marks', 'subjects.id', '=', 'marks.subject_id')
      ->where([
        ['marks.year_id', '=', $year],
        ['marks.semester_id', '=', $semester],
        ['marks.student_id', '=', $student],
      ])->get();
    
    $studentResult = Subject::all();
        
    foreach ($studentResult as $studentResultBySubject) {
      $subjectResult = [];
      foreach ($queryResult as $query) {
        if($query->subject_id == $studentResultBySubject->id) {
          array_push($subjectResult, $query);
        }
      }

      $studentResultBySubject['marks'] = $subjectResult;
    }

    return $studentResult;
  }

  public static function getStudentYearResult($student, $year) {

    $markTypes = MarkType::all();

    $queryResult = Subject::join('marks', 'subjects.id', '=', 'marks.subject_id')
      ->where([
        ['marks.year_id', '=', $year],
        ['marks.student_id', '=', $student],
        [ 'marks.mark_type_id', '=', $markTypes[count($markTypes) - 1]->id ],
      ])->get();

    $studentYearResult = Subject::all();
    
    foreach ($studentYearResult as $studentYearResultBySubject) {
      $subjectResult = [];

      foreach ($queryResult as $query) {
        if($query->subject_id == $studentYearResultBySubject->id) {
          $subjectResult[$query->semester_id] = ['mark' => $query->mark];
        }
      } 

      $sumOfSemesterMark = 0;

      foreach ($subjectResult as $semester => $result) {
        $sumOfSemesterMark +=  $result['mark'] * Semester::find($semester)->coefficient;
      }

      $yearMark = $sumOfSemesterMark / Semester::getSumOfCoefficient();

      $subjectResult['year']['mark'] = (float) number_format(round($yearMark * 10) / 10, 1);

      $studentYearResultBySubject['marks'] = $subjectResult;
    }

    return $studentYearResult;
  }

  public static function getAverageSemester($year, $semester, $classroom, $student) {

    $sumOfCoefficient = Subject::getSumOfCoefficient();
    $subjects = Subject::all();
    $markTypes = MarkType::all();

    $sumOfMark = 0;

    foreach ($subjects as $subject) {
      $studentMark = Mark::where([
        ['year_id', '=', $year],
        ['semester_id', '=', $semester],
        ['classroom_id', '=', $classroom],
        ['student_id', '=', $student],
        ['subject_id', '=', $subject->id],
        ['mark_type_id', '=', $markTypes[count($markTypes) - 1]->id],
      ])->first();

      $sumOfMark += $studentMark->mark * $subject->coefficient;
    }

    $averageSemester = $sumOfMark / $sumOfCoefficient;
    
    return number_format(round($averageSemester * 10) / 10, 1);
  }

  public static function getAverageYear($year, $classroom, $student) {
    $semesters = Semester::all();

    $sumOfMark = 0;

    foreach ($semesters as $semester) {
      $sumOfMark += self::getAverageSemester($year, $semester->id, $classroom, $student) * $semester->coefficient;
    }

    $averageYear = $sumOfMark / Semester::getSumOfCoefficient();

    $averageYear = (float) number_format( round($averageYear * 10) / 10 , 1);

    return $averageYear;
  }

  public static function updateMarks($marks) {

    foreach ($marks as $mark) {
      $updateMark = Mark::where([
        ['year_id', '=', $mark['year_id']],
        ['semester_id', '=', $mark['semester_id']],
        ['classroom_id', '=', $mark['classroom_id']],
        ['subject_id', '=', $mark['subject_id']],
        ['student_id', '=', $mark['student_id']],
        ['mark_type_id', '=', $mark['mark_type_id']],
      ]);

      $updateMark->update([ 'mark' => $mark['mark']]);
    }

    return true;
    
  }

  public static function updateAverageMark($year, $semester, $classroom, $subject) {

    $markTypes = MarkType::all();
    $sumOfCoefficient = MarkType::getSumOfCoefficient();
    $studentMarks = self::getMarksOfClassroomBySubject($classroom, $subject, $year, $semester);

    foreach ($studentMarks as $student) {
      $sumOfMark = 0;

      foreach ($student->marks as $mark) {
        $markTypeOfMark = MarkType::find($mark->mark_type_id);
        $sumOfMark += $mark->mark * $markTypeOfMark->coefficient;
      }

      $avgMark = $sumOfMark / $sumOfCoefficient;

      $updateMark = Mark::where([
        ['year_id', '=', $year],
        ['semester_id', '=', $semester],
        ['classroom_id', '=', $classroom->id],
        ['subject_id', '=', $subject],
        ['student_id', '=', $student->id],
        ['mark_type_id', '=', $markTypes[count($markTypes) - 1]->id],
      ]);

      $updateMark->update([ 'mark' => $avgMark ]);
    }

    return true;
  }

  
}
