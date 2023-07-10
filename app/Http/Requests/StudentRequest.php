<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{

  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return (session()->get('currentUser') && session()->get('currentUser')['role'] == 1) 
      ? true 
      : false;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
   */
  public function rules(): array {
    $now = date('Y', time());
    $minYear = $now - 15;
    $maxYear = $now - 20;
    
    $minAge = date('31-12-'.$minYear);
    $maxAge = date('01-01-'.$maxYear);

    return [
      'first_name' => ['required'],
      'last_name' => ['required'],
      'dob' => 'required|before_or_equal:'.$minAge.'|after_or_equal:'.$maxAge,
      'gender' => 'required',
      'address' => 'required',
      'email' => 'required|email',
      'parent_name' => ['required'],
      'parent_phone' => ['required', 'size:10', 'regex:/^0[1-9][0-9]+/'],
    ];
  }
  
  public function messages(): array {
    return [
      'first_name.required' => 'Vui lòng nhập Họ',
      'last_name.required' => 'Vui lòng nhập Tên', 

      'dob.required' => 'Vui lòng nhập ngày sinh', 
      'dob.before_or_equal' => 'Học sinh từ 15 đến 20 tuổi', 
      'dob.after_or_equal' => 'Học sinh từ 15 đến 20 tuổi', 

      'gender.required' => 'Vui lòng chọn giới tính',

      'address.required' => 'Vui lòng nhập địa chỉ',

      'email.required' => 'Vui lòng nhập email',
      'email.email' => 'Email không phù hợp',

      'parent_name.required' => 'Vui lòng nhập tên phụ huynh',

      'parent_phone.required' => 'Vui lòng nhập số điện thoại phụ huynh',
      'parent_phone.size' => 'Số điện thoại không phù hợp',
      'parent_phone.regex' => 'Số điện thoại không phù hợp',
    ];
  }
  
}
