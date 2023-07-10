<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
  
  public function index() {

    try {
      $data = Rule::all()->first()->toArray();
      $rules = [];
  
      foreach ($data as $key => $value) {
        $rule = [];
        switch ($key) {
          case 'class_size':
            $rule = [
              'name' => 'Sĩ số tối đa',
              'key' => $key,
              'value' => $value
            ];
            array_push($rules, $rule);
            break;
          case 'max_age':
            $rule = [
              'name' => 'Tuổi tiếp nhận tối đa',
              'key' => $key,
              'value' => $value
            ];
            array_push($rules, $rule);
            break;
          case 'min_age':
            $rule = [
              'name' => 'Tuổi tiếp nhận tối thiểu',
              'key' => $key,
              'value' => $value
            ];
            array_push($rules, $rule);
            break;
          case 'pass_mark':
            $rule = [
              'name' => 'Điểm đạt',
              'key' => $key,
              'value' => $value
            ];
            array_push($rules, $rule);
            break;
        }
      }
  
      return view('regulations.rule', compact('rules'));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

 
  public function update(Request $request) {
    $formData = $request->validate(
      [
        'class_size' => 'required|numeric|min:1',
        'max_age' => 'required|numeric|min:1',
        'min_age' => 'required|numeric|min:1',
        'pass_mark' => 'required|numeric|between:0,10',
      ],
      [
        'class_size.required' => 'Vui lòng nhập giá trị',
        'class_size.numeric' => 'Vui lòng nhập giá trị phù hợp',
        'class_size.min' => 'Giá trị từ :min trở lên',

        'max_age.required' => 'Vui lòng nhập giá trị',
        'max_age.numeric' => 'Vui lòng nhập giá trị phù hợp',
        'max_age.min' => 'Giá trị từ :min trở lên',

        'min_age.required' => 'Vui lòng nhập giá trị',
        'min_age.numeric' => 'Vui lòng nhập giá trị phù hợp',
        'min_age.min' => 'Giá trị từ :min trở lên',

        'pass_mark.required' => 'Vui lòng nhập giá trị',
        'pass_mark.numeric' => 'Vui lòng nhập giá trị phù hợp',
        'pass_mark.between' => 'Giá trị từ :min đến :max',
      ]

    );

    try {
      $rule = Rule::first();
  
      $rule->update([
        'class_size' => (int) $formData['class_size'],
        'min_age' => (int) $formData['min_age'],
        'max_age' => (int) $formData['max_age'],
        'pass_mark' => (float) $formData['pass_mark'],
      ]);
  
      return redirect()->back()->with('successMessage', 'Cập nhật quy định thành công');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

}
