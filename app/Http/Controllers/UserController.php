<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return route('home');
        } else {
            return back()->with('message', 'Account is not Valid!');
        }
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
        return redirect('/');
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
