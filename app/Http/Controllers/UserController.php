<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public $successStatus = 200;

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('deekey')->accessToken;
            return response()->json(['success' => $success, 'message' => 'Login Successfully', $this->successStatus]);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'username' => 'required',
                'password' => 'required',
                'address' => 'required',
                'city' => 'required',
                'phone_number' => 'required',
                'avatar' => 'required'
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('deekey')->accessToken;
        $success['username'] = $user->username;
        return response()->json(['success' => $success, 'message' => 'Registration Successfully', $this->successStatus]);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user, $this->successStatus]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['success' => true, 'message' => 'Logout Succesfully', $this->successStatus]);
    }
}
