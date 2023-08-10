<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
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
        Artisan::call('cache:clear');
        if (!$user->hasVerifiedAccount()) {
            $token = Password::createToken($user);
            return redirect()->route('update.pass', [ 'token' => $token,
            'email' => $request->email]);
        }
        if ($user) {
            $domain = $request->server('HTTP_HOST');
            $get_id = $user->waroeng_id;
            $get_m_w = DB::table('m_w')->where('m_w_id',$get_id)->first();
            if ($get_m_w->m_w_m_w_jenis_id == 1 or $get_m_w->m_w_m_w_jenis_id == 2 and $domain == 'sipedaspusat.waroengss.com') {
                auth()->logout();
                return redirect()->route('users.noakses')->with('anda tidak dapat mengakses kantor pusat');
            } else {
                return redirect()->intended();
            }
        }
    }
    public function change_pass(Request $request)
    {
        $email = $request->email;
        $token = $request->token;
        $verified = Carbon::now();
        return view('auth.reset',compact('email','token','verified'));
    }
    public function update_pass_save(Request $request)
    {
        DB::table('users')->where('email',$request->email)->update(['password'=> Hash::make($request->password),'verified'=>$request->verified]); 
        auth()->logout();       
        return redirect('/login');
    }
    public function no_akses(Request $request) {
        return view('auth.no_akses');
        
    }
}
