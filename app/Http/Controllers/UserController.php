<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Treatment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class UserController extends Controller
{
    public $successStatus = 200;

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('deekey')->accessToken;
            return response()->json(
                [
                    'success' => $success,
                    'message' => 'Login Successfully'
                ],
                $this->successStatus
            );
        } else {
            return response()->json([
                'error' => 'Unauthorised'
            ], 401);
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
            return response()->json([
                'error' => $validator->errors()
            ], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['username'] = $user->username;
        $success['token'] = $user->createToken('deekey')->accessToken;
        return response()->json(
            [
                'success' => $success,
                'message' => 'Registration Successfully'
            ],
            $this->successStatus
        );
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(
            [
                'success' => $user
            ],
            $this->successStatus
        );
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(
            [
                'success' => true,
                'message' => 'Logout Succesfully'
            ],
            $this->successStatus
        );
    }

    public function update(Request $request, $id)
    {
        $input = User::findOrFail($id);

        $input->email = $request->email;
        $input->username = $request->username;
        $input->address = $request->address;
        $input->city = $request->city;
        $input->phone_number = $request->phone_number;
        $input->avatar = $request->avatar;

        $input->save();

        return response()->json([
            'success' => true,
            'message' => 'Customer Updated'
        ]);
    }

    public function destroy()
    {
        $user = Auth::user();
        return response()->json([
            'success' => $user, 'message' => 'User Deleted'
        ], $this->successStatus);
    }
}
