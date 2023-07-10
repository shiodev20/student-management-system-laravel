<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

  public function show(string $id) {

    try {
      $user = Auth::user()->employee
      ? Auth::user()->employee
      : (Auth::user()->teacher ? Auth::user()->teacher : Auth::user()->student);
  
      return view('users.show', compact('user'));

    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }

  public function updatePassword(Request $request) {

    try {
      $validator = Validator::make($request->all(),
        [
          'oldPassword' => 'required',
          'newPassword' => 'required|confirmed',
          'newPassword_confirmation' => 'required',
        ],
        [
          'oldPassword.required' => 'Vui lòng nhập mật khẩu cũ',
          'newPassword.required' => 'Vui lòng nhập mật khẩu mới',
          'newPassword.confirmed' => 'Mật khẩu nhập lại không chính xác',
          'newPassword_confirmation.required' => 'Vui lòng nhập mật khẩu nhập lại',
        ]
      );

      if($validator->fails()) {
        return [
          'status' => false,
          'messages' => $validator->messages()
        ];
      }

      $formData = [
        'oldPassword' => $request->oldPassword,
        'newPassword' => $request->newPassword,
      ];

      $isMatch = Hash::check($formData['oldPassword'], Auth::user()->password);

      if(!$isMatch) {
        return [
          'status' => false,
          'messages' => [
            'oldPassword' => ['Mật khẩu không chính xác'],
          ]
        ];
      }

      $account = Account::find(Auth::user()->id);
      $account->update([
        'password' => Hash::make($formData['newPassword']),
      ]);

      return [
        'status'=> true,
        'message' => 'đổi mật khẩu thành công'
      ];
    } catch (\Throwable $th) {
      return redirect()->back()->with('errorMessage', 'Lỗi hệ thống vui lòng thử lại sau');
    }
  }
  
}
