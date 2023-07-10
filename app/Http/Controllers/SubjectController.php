<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
  public function index() {

    try {
      $subjects = Subject::all();
  
      return view('regulations.subject', compact('subjects'));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function update(Request $request) {

    try {
      $formData['ids'] = $request->ids;
      $formData['names'] = $request->names;
      $formData['coefficients'] = $request->coefficients;
  
      for ($i=0; $i < count($formData['ids']); $i++) { 
       $subject = Subject::find($formData['ids'][$i]);
  
       $subject->name = $formData['names'][$i];
       $subject->coefficient = (int) $formData['coefficients'][$i];
  
       $subject->save();
      }
  
      return redirect()
        ->back()
        ->with('successMessage', 'Cập nhật môn học thành công');
      
    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
    
  }
}
