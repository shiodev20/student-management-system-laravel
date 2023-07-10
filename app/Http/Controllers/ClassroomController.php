<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomDetail;
use App\Models\Grade;
use App\Models\Mark;
use App\Models\Rule;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingAssignment;
use App\Models\Year;
use Exception;
use Illuminate\Http\Request;


class ClassroomController extends Controller {
  
  public function index() {

    try {
      $years = Year::all();
      $grades = Grade::all();
      $currentYear = Year::getCurrentYear();
      $selectedYear = $currentYear->id;
      $classrooms = Classroom::getClassroomByYear($currentYear->id);
      
      return view('classrooms.index', compact([
        'years',
        'currentYear',
        'selectedYear',
        'grades',
        'classrooms',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

 
  public function create() {
    try {
      $currentYear = Year::getCurrentYear();
      $grades = Grade::all();
  
      return view('classrooms.create', compact([
        'currentYear',
        'grades'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

 
  public function store(Request $request) {
    $request->validate(
      [
        'year' => 'required',
        'grade' => 'required',
        'quantity' => 'required|numeric|min:1'
      ],
      [
        'year.required' => 'Vui lòng chọn năm học',

        'grade.required' => 'Vui lòng chọn khối lớp',

        'quantity.required' => 'Vui lòng nhập số lượng lớp',
        'quantity.numeric' => 'Số lượng lớp phải là ký tự số',
        'quantity.min' => 'Số lượng lớp phải lớn hơn 0',
      ]
    );

    try {
  
      $formData['year'] = $request->year;
      $formData['grade'] = $request->grade;
      $formData['quantity'] = $request->quantity;
  
      Classroom::addClassrooms($formData['year'], $formData['grade'], $formData['quantity']);
  
      return redirect()
        ->route('classrooms.create')
        ->with('successMessage', 'Tạo lớp học thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }


  public function show(Classroom $classroom) {

    try {
      $currentYear = Year::getCurrentYear();
      $currentSemester = Semester::getCurrentSemester();

      $students = $classroom->students;
      $subjectTeachers = Teacher::getSubjectTeacherByClassroom($classroom->id);

      return view('classrooms.show', compact([
        'classroom',
        'currentYear',
        'currentSemester',
        'students',
        'subjectTeachers',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    
  }

  // GET: assign students
  public function assignStudent(Request $request, Classroom $classroom) {

    try {
      $students = Student::getNoClassroomAssignmentStudents($classroom)->paginate(25);
      $classSize = Rule::all()[0]->class_size;

      return view('classrooms.assign-student', compact([
        'classroom',
        'students',
        'classSize',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    
  }
  
  // POST: assign students
  public function processAssignStudent(Request $request, Classroom $classroom) {

    try {
      $formData['students'] = $request->students;

      $result = Classroom::addStudentsToClassroom($classroom, $formData['students']);

      return redirect()
        ->route('classrooms.assignStudent', ['classroom' => $classroom->id])
        ->with('successMessage', 'Thêm học sinh vào lớp thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  //GET: assign headteacher
  public function assignHeadTeacher(Request $request, Classroom $classroom) {
    try {
      $teachers = Teacher::getNoAssignmentHeadTeacher();

      return view('classrooms.assign-headTeacher', compact([
        'classroom',
        'teachers',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  //PUT: assign head teacher
  public function processAssignHeadTeacher(Request $request, Classroom $classroom) {

    try {
      $formData['headTeacher'] = $request->headTeacher;

      if(!$formData['headTeacher']) {
        throw new Exception("Vui lòng chọn giáo viên", 1);
      }

      $result = Classroom::addHeadTeacherToClassroom($classroom, $formData['headTeacher']);
  
      return redirect()
        ->route('classrooms.assignHeadTeacher', ['classroom' => $classroom->id])
        ->with('successMessage', 'Phân công giáo viên chủ nhiệm thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', $th ? $th->getMessage() : 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  //GET: assign subject teacher
  public function assignSubjectTeacher(Request $request, Classroom $classroom) {
    try {
      $subjects = $classroom->headTeacher
        ? Subject::where('id', '<>', $classroom->headTeacher->subject_id)->get()
        : Subject::all();
        
      return view('classrooms.assign-subjectTeacher', compact([
        'classroom',
        'subjects',
      ]));
      
    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  //PUT: assign subjectteacher
  public function processAssignSubjectTeacher(Request $request, Classroom $classroom) {

    try {
      $assignments = [];
  
      foreach ($request->except(['_token', '_method']) as $subject => $teacher) {
        if(!is_null($teacher)) {
          array_push($assignments, [
            'subjectId' => $subject,
            'subjectTeacherId' => $teacher,
          ]);
        }
      }

      if(!$assignments) throw new Exception("Vui lòng chọn giáo viên", 1);
      
      $result =  Classroom::addSubjectTeachersToClassroom($classroom->id, $assignments);
  
      return redirect()
        ->route('classrooms.show', ['classroom' => $classroom->id])
        ->with('successMessage', 'Phân công giáo viên bộ môn thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', $th ? $th->getMessage() : 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
  

  public function destroy(Classroom $classroom) {
    try {
      $isStarted = count(ClassroomDetail::where('classroom_id', '=', $classroom->id)->get()) ? true : false;

    if(!$isStarted) {
      $teachingAssignments = TeachingAssignment::where('classroom_id', '=', $classroom->id);
      $teachingAssignments->delete();

      $classroom->delete();

      return redirect()->back()->with('successMessage', 'Xóa thành công lớp học '.$classroom->id);
    }
    else return redirect()->back()->with('errorMessage', 'Không thể xóa lớp học '.$classroom->id);

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    
  }


  public function deleteHeadTeacher(Classroom $classroom) {
    try {
      $teachingAssignment = TeachingAssignment::where([
        ['classroom_id', '=', $classroom->id],
        ['subject_id', '=', $classroom->headTeacher->subject->id]
      ])->first();
  
      $teachingAssignment->update([ 'subject_teacher_id' => null ]);
      $classroom->update([ 'head_teacher_id' => null ]);
  
      return redirect()
        ->back()
        ->with('successMessage', 'Xóa giáo viên chủ nhiệm thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function deleteStudent(Classroom $classroom, Student $student) {
    try {
      $studentMarks = Mark::where([
        ['year_id', '=', $classroom->year_id],
        ['classroom_id', '=', $classroom->id],
        ['student_id', '=', $student->id],
      ]);
  
  
      $classroomDetail = ClassroomDetail::where([
        ['classroom_id', '=', $classroom->id],
        ['student_id', '=', $student->id],
      ]);
  
      $studentMarks->delete();
      $classroomDetail->delete();
      $classroom->update([ 'size' => $classroom->size - 1]);
  
      return redirect()
        ->back()
        ->with('successMessage', "Xóa học sinh $student->id thành công");

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function deleteAllStudents(Classroom $classroom) {
    try {
      $classroomDetails = ClassroomDetail::where('classroom_id', '=', $classroom->id)->get();
  
      foreach ($classroomDetails as $classroomDetail) {
  
        $studentMarks = Mark::where([
          ['year_id', '=', $classroom->year_id],
          ['classroom_id', '=', $classroom->id],
          ['student_id', '=', $classroomDetail->student_id],
        ]);
        
        $studentMarks->delete();
        ClassroomDetail::destroy($classroomDetail->id);
      }
  
      $classroom->update([ 'size' => 0 ]);
  
      return redirect()
        ->back()
        ->with('successMessage', "Xóa tất cả học sinh thành công");

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function deleteSubjectTeacher(Classroom $classroom, Teacher $teacher) {
    try {
      $teachingAssignment = TeachingAssignment::where([
        ['classroom_id', '=', $classroom->id],
        ['subject_teacher_id', '=', $teacher->id],
      ])->first();
  
      $teachingAssignment->update([ 'subject_teacher_id' => null]);
  
      return redirect()
        ->back()
        ->with('successMessage', "Xóa giáo viên $teacher->id thành công");

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    
  }


  public function deleteAllSubjectTeachers(Classroom $classroom) {
    try {
      $teachingAssignments = TeachingAssignment::where([
        ['classroom_id', '=', $classroom->id],
        ['subject_teacher_id', '<>', null],
        ['subject_teacher_id', '<>', $classroom->head_teacher_id]
      ])->get();
  
      foreach ($teachingAssignments as $teachingAssignment) {
        $teachingAssignment->update([ 'subject_teacher_id' => null ]);
      }
  
      return redirect()
        ->back()
        ->with('successMessage', "Xóa tất cả giáo viên bộ môn thành công");

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    

  }


  public function search(Request $request) {
    try {
      $selectedYear = $request->query('year');
    
      $years = Year::all();
      $grades = Grade::all();
      $currentYear = Year::getCurrentYear();
      $classrooms = Classroom::getClassroomByYear($selectedYear);

      return view('classrooms.index', compact([
        'years', 
        'selectedYear',
        'currentYear',
        'grades', 
        'classrooms'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    
  }

}
