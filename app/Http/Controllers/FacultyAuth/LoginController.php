<?php

namespace App\Http\Controllers\FacultyAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect faculties after login.
     *
     * @var string
     */
    protected $redirectTo = '/faculty/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }*/

    protected function guard()
    {
        return auth()->guard('faculty');
    }

    public function showLoginForm()
    {
        return view('Faculty.login');
    }
}
