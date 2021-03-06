<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Models\Staff;
use Hash;
use Validator;
use Auth;

class ChangePasswordController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('permission:Change Password', ['only' => ['changePasswordStaff']]);
    }

    public function changePasswordStaff(Request $request)
    {
        // This kind of validator must be changed
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|same:new_password|min:6',
            'confirm_new_password' => 'required|same:new_password',
            'current_password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user = Auth::user()->token();

        if ($user) {
            if (\Hash::check($request->current_password, Auth::user()->password)) {
                Staff::find(Auth::user()->id)->update(["password" => bcrypt($request->new_password)]);
            } else {
                return response()->json(['error' => 'Incorrect current password!']);
            }
        }

        $user->revoke();

        return response()->json([
            'success' => true,
            'message' => 'Password was changed successfully. Please login to continue',
        ]);

    }
}
