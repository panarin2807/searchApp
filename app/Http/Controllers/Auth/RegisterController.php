<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Prefix;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $message = [
            'fname.required' => 'กรุณาระบุชื่อจริง',
            'lname.required' => 'กรุณาระบุนามสกุล',
            'email.required' => 'กรุณาระบุ E-mail',
            'email.email' => 'กรุณากรอก E-mail ให้ถูกต้อง',
            'username.required' => 'กรุณาระบุ Username',
        ];

        return Validator::make($data, [
            'prefix' => ['required'],
            'fname' => ['required', 'string', 'max:100'],
            'lname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'username' => [
                'required', 'string', 'min:10', 'max:10', 'unique:users',
                function ($attr, $value, $fail) {
                    $splited = explode('-', $value);
                    if (count($splited) != 2) {
                        $fail('กรุณาระบุ Username ให้ถูกต้อง');
                    }
                    if ($value == '1234567890') {
                        $fail('Username ไม่ถูกต้อง');
                    }
                }
            ],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], $message);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'prefix_id' => $data['prefix'],
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password'],),
        ]);
    }

    public function showRegistrationForm()
    {
        $prefixes = Prefix::all();
        return view('auth.register', [
            'title' => 'Register',
            'registerRoute' => 'register',
            'registerType' => '0',
            'prefixes' => $prefixes
        ]);
    }
}
