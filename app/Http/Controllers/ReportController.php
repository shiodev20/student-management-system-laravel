<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Mark;
use App\Models\MarkType;
use App\Models\Rank;
use App\Models\Rule;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller {
 
  public function reportClassroom() {

    try {
      $years = Year::all();
      $semesters = Semester::all();
      
      return view('reports.classroom', compact([
        'years',
        'semesters',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
   
  }


  public function processReportClassroom(Request $request) {
    try {
      $validator = Validator::make($request->all(), 
        [
          'year' => 'required',
          'semester' => 'required',
        ],
        [
          'year.required' => 'Vui lòng chọn năm học',
          'semester.required' => 'Vui lòng chọn học kỳ',
        ],
      );

      if($validator->fails()) {
        return [
          'status' => false,
          'messages'=> $validator->messages(),
        ];
      }

      $formData = [
        'year' => $request->year,
        'semester' => $request->semester,
      ];

      $classrooms = Classroom::where('year_id', '=', $formData['year'])->get();
      $result = [];
      $ranks = Rank::all();
      $grades = Grade::all();

      foreach ($classrooms as $classroom) {
        $classroomResult = [
          'id' => $classroom->id,
          'name' => $classroom->name,
          'size' => $classroom->size,
          'grade' => $classroom->grade_id,
          'ranks' => []
        ];

        foreach ($ranks as $rank) {
          array_push($classroomResult['ranks'], [
            'id' => $rank->id,
            'name' => $rank->name,
            'quantity' => 0
          ]);
        }

        $students = $classroom->students;

        foreach ($students as $student) {
          $averageMark = $formData['semester'] == 'all'
          ? (float)Mark::getAverageYear($formData['year'], $classroom->id, $student->id)
          : (float)Mark::getAverageSemester($formData['year'], $formData['semester'], $classroom->id, $student->id);

          $studentRank = Rank::getRankByMark($averageMark);

          for ($i=0; $i < count($classroomResult['ranks']); $i++) { 
            if($studentRank->id == $classroomResult['ranks'][$i]['id']) {
              $classroomResult['ranks'][$i]['quantity'] += 1;
            }
          }
        }

        array_push($result, $classroomResult);
      }

      $classroomReports = [];

      foreach ($grades as $grade) {
        $classroomReports[$grade->id] = [];

        foreach ($result as $item) {
          if($item['grade'] == $grade->id) array_push($classroomReports[$grade->id], $item);
        }
      }

      return [
        'status' => true,
        'result' => [
          'grades' => $grades,
          'ranks' => $ranks,
          'classroomReports' => $classroomReports
        ],
      ];

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function reportSubjectClassroom() {
    try {
      $years = Year::all();
      $semesters = Semester::all();
      $subjects = Subject::all();
      $classrooms = Classroom::all();

      return view('reports.subject-classroom', compact([
        'years',
        'semesters',
        'subjects',
        'classrooms',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }

  
  public function processReportSubjectClassroom(Request $request) {
    try {
      $validator = Validator::make($request->all(), 
        [
          'year' => 'required',
          'semester' => 'required',
          'subject' => 'required',
          'classroom' => 'required'
        ],
        [
          'year.required' => 'Vui lòng chọn năm học',
          'semester.required' => 'Vui lòng chọn học kỳ',
          'subject.required' => 'Vui lòng chọn môn học',
          'classroom.required' => 'Vui lòng chọn lớp học',
        ],
      );

      if($validator->fails()) {
        return [
          'status' => false,
          'messages'=> $validator->messages(),
        ];
      }

      $formData = [
        'classroom' => $request->classroom,
        'subject' => $request->subject,
        'year' => $request->year,
        'semester' => $request->semester,
      ];

      $classroom = Classroom::find($formData['classroom']);

      return [ 
        'status' => true, 
        'result' => [
          'markTypes' => MarkType::all(),
          'studentMarks' => Mark::getMarksOfClassroomBySubject(
            $classroom,
            $formData['subject'],
            $formData['year'],
            $formData['semester']
          ),
        ]
      ];

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }


  public function reportSubject() {

    try {
      $years = Year::all();
      $semesters = Semester::all();
      $subjects = Subject::all();
  
      return view('reports.subject', compact([
        'years',
        'semesters',
        'subjects'
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function processReportSubject(Request $request) {

    try {
      $validator = Validator::make($request->all(), 
        [
          'year' => 'required',
          'semester' => 'required',
          'subject' => 'required',
        ],
        [
          'year.required' => 'Vui lòng chọn năm học',
          'semester.required' => 'Vui lòng chọn học kỳ',
          'subject.required' => 'Vui lòng chọn môn học',
        ],
      );
  
      if($validator->fails()) {
        return [
          'status' => false,
          'messages'=> $validator->messages(),
        ];
      }
  
      $formData = [
        'year' => $request->year,
        'semester' => $request->semester, 
        'subject' => $request->subject,
      ];
  
      $grades = Grade::all();
      $MarkTypes = MarkType::all();
      $passMark = Rule::first()->pass_mark;
  
      $result = Mark
        ::join('classrooms', 'marks.classroom_id', '=', 'classrooms.id')
        ->where([
          ['marks.year_id', '=', $formData['year']],
          ['marks.semester_id', '=', $formData['semester']],
          ['marks.subject_id', '=', $formData['subject']],
          ['marks.mark_type_id', '=', $MarkTypes[count($MarkTypes) - 1]->id],
          ['marks.mark', '>=', $passMark]
        ])
        ->selectRaw('classrooms.id as classroom_id, classrooms.name, classrooms.size, classrooms.grade_id, COUNT(mark) as pass_quantity')
        ->groupBy('classrooms.id', 'classrooms.name', 'classrooms.size')->get();
      
  
        $subjectReports = [];
  
        foreach ($grades as $grade) {
          $subjectReports[$grade->id] = [];
  
          foreach ($result as $item) {
            if($item->grade_id == $grade->id) {
              array_push($subjectReports[$grade->id], [
                'id' => $item->classroom_id,
                'name' => $item->name,
                'size' => $item->size,
                'pass_quantity' => $item->pass_quantity,
                'pass_ratio' => (100 * $item->pass_quantity) / $item->size
              ]);
            }
          }
        }
      
        return [
        'status'=> true,
        'result' => [
          'grades' => $grades,
          'subjectReports' => $subjectReports,
        ],
      ];

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function reportSemester() {

    try {
      $years = Year::all();
      $semesters = Semester::all();
  
      return view('reports.semester',compact([
        'years',
        'semesters',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function processReportSemester(Request $request) {
    try {
      $validator = Validator::make($request->all(), 
        [
          'year' => 'required',
          'semester' => 'required',
        ],
        [
          'year.required' => 'Vui lòng chọn năm học',
          'semester.required' => 'Vui lòng chọn học kỳ',
        ],
      );
  
      if($validator->fails()) {
        return [
          'status' => false,
          'messages'=> $validator->messages(),
        ];
      }
  
      $formData = [
        'year' => $request->year,
        'semester' => $request->semester, 
      ];
  
      $semesterReports = [];
      $grades = Grade::all();
      $classrooms = Classroom::where('year_id', '=', $formData['year'])->get();
  
      $passMark = Rule::first()->pass_mark;
      $result = [];
  
      foreach ($classrooms as $classroom) {
        $students = $classroom->students;
        $item = [
          'id' => $classroom->id,
          'name' => $classroom->name,
          'size' => $classroom->size,
          'grade' => $classroom->grade_id,
          'pass_quantity' => 0,
          'pass_ratio' => 0
        ];
  
        foreach ($students as $student) {
          $studentAverageMark = Mark::getAverageSemester($formData['year'], $formData['semester'], $classroom->id, $student->id);
          if($studentAverageMark >= $passMark) $item['pass_quantity'] += 1;
        }
  
        $item['pass_ratio']  = (100 * $item['pass_quantity']) / $item['size'];
  
        array_push($result, $item);
      }
  
      foreach ($grades as $grade) {
        $semesterReports[$grade->id] = [];
  
        foreach ($result as $item) {
          if($item['grade'] == $grade->id) array_push($semesterReports[$grade->id], $item);
        }
      }
  
      return [
        'status' => true,
        'result' => [
          'grades' => $grades,
          'semesterReports' => $semesterReports,
        ],
      ];

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function reportYear() {

    try {
      $years = Year::all();
  
      return view('reports.year', compact([
        'years',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }


  public function processReportYear(Request $request) {
    try {
      $validator = Validator::make($request->all(), 
        [ 'year' => 'required' ],
        [ 'year.required' => 'Vui lòng chọn năm học' ],
      );
  
      if($validator->fails()) {
        return [
          'status' => false,
          'messages'=> $validator->messages(),
        ];
      }
  
      $formData['year'] = $request->year;
  
      $yearReports = [];
      $grades = Grade::all();
      $classrooms = Classroom::where('year_id', '=', $formData['year'])->get();
      $passMark = Rule::first()->pass_mark;
  
      $result = [];
  
  
      foreach ($classrooms as $classroom) {
        $students = $classroom->students;
  
        $item = [
          'id' => $classroom->id,
          'name' => $classroom->name,
          'size' => $classroom->size,
          'grade' => $classroom->grade_id,
          'pass_quantity' => 0,
          'pass_ratio' => 0
        ];
  
        foreach ($students as $student) {
          $studentAverageMark = Mark::getAverageYear($formData['year'], $classroom->id, $student->id);
          if($studentAverageMark >= $passMark) $item['pass_quantity'] += 1;
        }
  
        $item['pass_ratio']  = (100 * $item['pass_quantity']) / $item['size'];
  
        array_push($result, $item);
      }
  
      foreach ($grades as $grade) {
        $yearReports[$grade->id] = [];
  
        foreach ($result as $item) {
          if($item['grade'] == $grade->id) array_push($yearReports[$grade->id], $item);
        }
      }
  
      return [
        'status' => true,
        'result' => [
          'grades' => $grades,
          'yearReports' => $yearReports,
        ],
      ];

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}