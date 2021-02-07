<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register', [
            'title' => 'Student Register',
            'registerRoute' => 'student.register',
            'registerType' => '1'
        ]);
    }

    public function register(Request $request)
    {

        $this->validator($request);

        Student::create([
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);

        return view('auth.login', [
            'title' => 'Student Login',
            'loginRoute' => 'student.login',
            'forgotPasswordRoute' => 'student.password.request',
            'loginType' => '1'
        ]);
    }

    protected function validator(Request $request)
    {
        $rules = [
            'fname' => ['required', 'string', 'max:100'],
            'lname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'username' => ['required', 'string', 'max:100', 'unique:students'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];

        $messages = [
            //'username.exists' => 'These credentials do not match our records.',
        ];

        $request->validate($rules, $messages);
    }
}
