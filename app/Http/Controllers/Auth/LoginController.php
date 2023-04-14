<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect('/login');
    }
    protected function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedAccount()) {
            auth()->logout();
            $token = Password::createToken($user);
            return redirect()->route('update.pass', [ 'token' => $token,
            'email' => $request->email]);
        }
    }
    public function change_pass(Request $request)
    {
        $email = $request->email;
        $token = $request->token;
        $verified = Carbon::now();
        return view('auth.reset',compact('email','token','verified'));
    }
}
