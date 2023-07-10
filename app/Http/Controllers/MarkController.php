<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Mark;
use App\Models\MarkType;
use App\Models\Semester;
use App\Models\Teacher;
use App\Models\Year;
use Illuminate\Http\Request;

class MarkController extends Controller
{
  public function edit(Classroom $classroom) {

    try {
      $headClassroom = $classroom;
      $currentYear = Year::getCurrentYear();
      $currentSemester = Semester::getCurrentSemester();
      $subject = Teacher::find(session('currentUser')['id'])->subject;
      $markTypes = MarkType::all();
      $students = Mark::getMarksOfClassroomBySubject($classroom, $subject->id, $currentYear->id, $currentSemester->id);
  
      return view('marks.create', compact([
        'headClassroom',
        'classroom',
        'currentYear',
        'currentSemester',
        'subject',
        'markTypes',
        'students',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');

    }

  }

  public function update(Request $request, Classroom $classroom) {

    try {
      $formData['year'] = $request->year;
      $formData['semester'] = $request->semester;
      $formData['subject'] = $request->subject;
      $formData['students'] = $request->students;
      $formData['markTypes'] = $request->except('_token', '_method', 'year', 'semester', 'subject', 'students');
  
      $data = [];
  
      foreach ($formData['markTypes'] as $markType => $marks) {
        for ($i = 0; $i < count($formData['students']); $i++) { 
          $item = [
            'year_id' => $formData['year'],
            'semester_id' => $formData['semester'],
            'classroom_id' => $classroom->id,
            'subject_id' => $formData['subject'],
            'student_id' => $formData['students'][$i],
            'mark_type_id' => $markType,
            'mark' => round($marks[$i] * 10) / 10,
          ];
  
          array_push($data, $item);
        }
      }
  
      $result = Mark::updateMarks($data);
  
      return redirect()
        ->back()
        ->with('successMessage', 'Cập nhật điểm thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function updateAverageMark(Request $request, Classroom $classroom) {

    try {
      $formData['year'] = $request->year;
      $formData['semester'] = $request->semester;
      $formData['subject'] = $request->subject;
  
      $result = Mark::updateAverageMark($formData['year'], $formData['semester'], $classroom, $formData['subject']);
  
      return redirect()
        ->back()
        ->with('successMessage', "Tính điểm trung bình lớp $classroom->id thành công");
      
    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}
