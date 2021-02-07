<?php

namespace App\Http\Controllers\Person\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // type 1 : custom student maybe
        return view('auth.login', [
            'title' => 'Personel Login',
            'loginRoute' => 'person.login',
            'forgotPasswordRoute' => 'person.password.request',
            'loginType' => '1'
        ]);
    }

    public function login(Request $request)
    {
        //Validation...

        //Login the admin...

        //Redirect the admin...

        $this->validator($request);

        if (Auth::guard('personel')->attempt($request->only('username', 'password'), $request->filled('remember'))) {
            //Authentication passed...
            return redirect()
                ->intended(route('person.home'))
                ->with('status', 'You are Logged in as Personel!');
        }

        //Authentication failed...
        return $this->loginFailed();
    }

    /**
     * Logout the admin.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        //logout the admin...
        Auth::guard('personel')->logout();
        return redirect()
            ->route('person.login')
            ->with('status', 'Admin has been logged out!');
    }

    /**
     * Validate the form data.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    private function validator(Request $request)
    {
        //validation rules.
        $rules = [
            'username'    => 'required|exists:personels|min:5|max:191',
            'password' => 'required|string|min:4|max:255',
        ];

        //custom validation error messages.
        $messages = [
            'username.exists' => 'These credentials do not match our records.',
        ];

        //validate the request.
        $request->validate($rules, $messages);
    }

    /**
     * Redirect back after a failed login.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginFailed()
    {
        //Login failed...
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Login failed, please try again!');
    }
}
