<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Year;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
  public function index() {

    try {
      $years = Year::all();
      $semesters = Semester::all();
  
      return view('regulations.schoolYear', compact('years', 'semesters'));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function update(Request $request) {

    try {
      $formData['year'] = $request->year;
      $formData['semester'] = $request->semester;
  
      $currentYear = Year::getCurrentYear();
      $currentSemester = Semester::getCurrentSemester();
  
      if($formData['year'] == $currentYear->id && $formData['semester'] != $currentSemester->id) {
        $semester = Semester::find($formData['semester']);
  
        $currentSemester->update(['status' => 0]);
        $semester->update(['status' => 1]);
      }
      else if($formData['year'] != $currentYear->id && $formData['semester'] == $currentSemester->id) {
        $year = Year::find($formData['year']);
  
        $currentYear->update(['status' => 0]);
        $year->update(['status' => 1]);
      }
      else if($formData['year'] != $currentYear->id && $formData['semester'] != $currentSemester->id) {
        $semester = Semester::find($formData['semester']);
        $year = Year::find($formData['year']);
  
        $currentYear->update(['status' => 0]);
        $currentSemester->update(['status' => 0]);
  
        $year->update(['status' => 1]);
        $semester->update(['status' => 1]);
      }
      else {
        return redirect()->back()->with('successMessage', 'Cập nhật niên khóa thành công');
      }
  
      return redirect()->back()->with('successMessage', 'Cập nhật niên khóa thành công');
      
    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}
