<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff;
use Hash;
use Validator;
use Auth;

class LoginController extends Controller
{
    public function userDashboard()
    {
        $users = User::all();
        $success =  $users;
        return response()->json($success, 200);
    }

    public function staffDashboard()
    {
        $users = Staff::all();
        $success =  $users;

        return response()->json($success, 200);
    }

    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if (auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])) {

            config(['auth.guards.api.provider' => 'user']);

            $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
            $success =  $user;
            $success['token'] =  $user->createToken('MyApp', ['user'])->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'Login Success!',
                'data'    => $user,
                'token'   => $success['token']
            ]);
        } else {
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function staffLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if (auth()->guard('staff')->attempt(['email' => request('email'), 'password' => request('password')])) {

            config(['auth.guards.api.provider' => 'staff']);

            $staff = Staff::select('staffs.*')->find(auth()->guard('staff')->user()->id);
            $success =  $staff;
            $success['token'] =  $staff->createToken('MyApp', ['staff'])->accessToken;

            return response()->json([
                'success' => true,
                'message' => 'Login Success!',
                'data'    => $staff,
                'token'   => $success['token']
            ]);
        } else {
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function logoutUser()
    {
        $user = Auth::user()->token();
        $user->revoke();
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Success!',
            ]);
        }
    }

    public function logoutStaff()
    {
        $user = Auth::user()->token();
        $user->revoke();
        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Success!',
            ]);
        }
    }
}
