<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

  // GET: login
  public function create() {
    return view('auth.login');
  }

  // POST: login
  public function store(Request $request) {
    try {
      $formData = $request->validate(
        [
          'email' => 'required|email|max:100',
          'password' => 'required|min:6'
        ],
        [
          'email.required' => 'Email không được bỏ trống',
          'email.email' => 'Email không phù hợp',
          'email.max' => 'Email không được vượt quá :max ký tự',
          'password.required' => 'Mật khẩu không được bỏ trống',
          'password.min' => 'Mật khẩu từ :min ký tự trở lên',
        ]
      );
  
      $account = Account::where('email', '=', $formData['email'])->first();
      if(!$account->status) return redirect()->route('login')->with('form-message', 'Email hoặc mật khẩu không chính xác');
  
      if (Auth::attempt($formData)) {
      
        $info = Auth::user()->employee
          ? Auth::user()->employee
          : (Auth::user()->teacher ? Auth::user()->teacher : Auth::user()->student);
  
        
          $currentUser = [
          'id' => $info->id,
          'firstName' => $info->first_name,
          'lastName' => $info->last_name,
          'role' => $info->role_id
        ];
  
        $request->session()->regenerate();
        $request->session()->put('currentUser', $currentUser);
  
        return redirect()->route('dashboard');
      }
      else {
        return redirect()->route('login')->with('form-message', 'Email hoặc mật khẩu không chính xác');
      }

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }

  }

  //GET: logout
  public function destroy(Request $request) {

    try {
      Auth::logout();
  
      $request->session()->invalidate();
      $request->session()->regenerateToken();
  
      return redirect()->route('login');

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
}
