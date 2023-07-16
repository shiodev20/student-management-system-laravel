<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Account;
use App\Models\Classroom;
use App\Models\Mark;
use App\Models\Student;
use App\Models\MarkType;
use App\Models\Rank;
use App\Models\Semester;
use App\Models\Year;
use App\Utils\GenerateId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

  public function index() {
    try {
      session()->forget(['search_info', 'search_type']);

      $students = Student
        ::orderBy('enroll_date', 'desc')->paginate(10);

      $currentYear = Year::getCurrentYear();
      $currentSemester = Semester::getCurrentSemester();

      return view('students.index', compact('students', 'currentYear', 'currentSemester'));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function create() {
    return view('students.create');
  }


  public function store(StudentRequest $request) {  

    try {
      $studentId = GenerateId::generateId('HS', 6);

      while (true) {
        if (Student::find($studentId)) $studentId = GenerateId::generateId('HS', 6);
        else break;
      }

      $student = [
        'id' => $studentId,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'dob' => $request->dob,
        'gender' => $request->gender,
        'address' => $request->address,
        'email' => $request->email,
        'parent_name' => $request->parent_name,
        'parent_phone' => $request->parent_phone,
        'role_id' => 3,
        'account_id' => null
      ];

      $accountId = GenerateId::generateId('TK', 6);
      while (true) {
        if (Account::find($accountId)) $accountId = GenerateId::generateId('TK', 6);
        else break;
      }

      $account['id'] = $accountId;
      $account['email'] = $student['email'];
      $account['password'] = Hash::make($student['id']);
      $createdAccount = Account::create($account);

      $student['account_id'] = $createdAccount->id;
      Student::create($student);

      return redirect()
        ->route('students.index')
        ->with('successMessage', 'Tiếp nhận học sinh ' . $student['id'] . ' thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function show(Request $request, Student $student) {

    try {
      $query = [
        'year' => $request->query('year'),
        'semester' => $request->query('semester')
      ];

      if ($query['semester'] == 'all') {
        return redirect(route('students.showYearResult', ['student' => $student->id]) . "?year=" . $query['year']);
      }

      $years = Year::all();
      $semesters = Semester::all();
      $markTypes = MarkType::all();
      $classroom = Classroom::getClassroomByStudent($student->id, $query['year']);
      $studentResult = [];
      $studentAverageSemester = null;
      $studentSemesterRank = null;

      if ($classroom) {
        $studentResult = Mark::getStudentResult($student->id, $query['year'], $query['semester']);
        $studentAverageSemester = Mark::getAverageSemester($query['year'], $query['semester'], $classroom->id, $student->id);
        $studentSemesterRank = Rank::getRankByMark($studentAverageSemester);
      }

      return view('students.show', compact([
        'years',
        'semesters',
        'student',
        'query',
        'classroom',
        'markTypes',
        'studentResult',
        'studentAverageSemester',
        'studentSemesterRank',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }


  public function showYearResult(Request $request, Student $student) {

    try {
      $query['year'] = $request->query('year');

      $years = Year::all();
      $semesters = Semester::all();
      $classroom = Classroom::getClassroomByStudent($student->id, $query['year']);
      $studentResult = Mark::getStudentYearResult($student->id, $query['year']);
      $studentAverageYear = Mark::getAverageYear($query['year'], $classroom->id, $student->id);
      $studentYearRank = Rank::getRankByMark($studentAverageYear);

      return view('students.show-yearResult', compact([
        'years',
        'semesters',
        'query',
        'student',
        'classroom',
        'studentResult',
        'studentAverageYear',
        'studentYearRank',
      ]));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }


  public function edit(Student $student) {
    return view('students.edit', compact('student'));
  }


  public function update(StudentRequest $request, Student $student) {

    try {
      $payload['first_name'] = $request->first_name;
      $payload['last_name'] = $request->last_name;
      $payload['dob'] = $request->dob;
      $payload['gender'] = $request->gender;
      $payload['address'] = $request->address;
      $payload['email'] = $request->email;
      $payload['parent_name'] = $request->parent_name;
      $payload['parent_phone'] = $request->parent_phone;

      $student->update($payload);

      return redirect()
        ->route('students.edit', ['student' => $student->id])
        ->with('successMessage', 'Cập nhật học sinh ' . $student->id . ' thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    
  }


  public function destroy(Student $student) {

    try {
      $account = $student->account;
      $account->status = 0;
      $account->save();

      $student->status = 0;
      $student->save();

      return redirect()
        ->back()
        ->with('successMessage', 'Thôi học học sinh ' . $student->id . ' thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }


  public function search(Request $request) {
    $searchQuery = [];

    if ($request->query('page')) {
      $searchQuery = [
        'search_info' => session('search_info'),
        'search_type' => session('search_type'),
      ];
    } 
    else {
      $searchQuery = $request->validate(
        [
          'search_info' => 'required',
          'search_type' => 'required',
        ],
        [
          'search_info.required' => 'Vui lòng nhập thông tin tìm kiếm',
          'search_type.required' => 'Vui lòng chọn loại tìm kiếm'
        ]
      );

      session()->put('search_type', $searchQuery['search_type']);
      session()->put('search_info', $searchQuery['search_info']);
    }

    try {
      $students = [];

      switch ($searchQuery['search_type']) {
        case 'student_id':
          $students = Student::where('id', '=', $searchQuery['search_info'])->paginate(10);
          break;
        case 'student_name':
          $students = Student::where('first_name', 'like', '%' . $searchQuery['search_info'] . '%')
            ->orWhere('last_name', 'like', '%' . $searchQuery['search_info'] . '%')
            ->orderBy('enroll_date', 'desc')
            ->paginate(10);
          break;
      }

      if (!count($students)) {
        return redirect()->route('students.index')->with('errorMessage', 'Không tìm thấy học sinh');
      }

      $currentYear = Year::getCurrentYear();
      $currentSemester = Semester::getCurrentSemester();

      return view('students.index', compact('students', 'currentYear', 'currentSemester'));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }
}
