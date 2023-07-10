<?php

namespace App\Http\Controllers;

use App\Models\MarkType;
use Illuminate\Http\Request;

class MarkTypeContoller extends Controller
{
  public function index() {
    try {
      $markTypes = MarkType::all();

      return view('regulations.markType', compact('markTypes'));

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
        $markType = MarkType::find($formData['ids'][$i]);
  
        $markType->name = $formData['names'][$i];
        $markType->coefficient = (int) $formData['coefficients'][$i];
  
        $markType->save();
      }
  
      return redirect()
        ->back()
        ->with('successMessage', 'Cập nhật học vụ thành công');
        
    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}
