<?php

namespace App\Http\Controllers\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Modules\UserLogin\Models\UserLogin;
use Browser;
use App\Models\ActivityLog;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Session;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->redirectTo = url()->previous();
    }

    protected function authenticated(Request $request, $user) {
        if ($user) {
           $this->ActivityLastLogin($request ,$user);
        }
       // dd($user);
        if ($user->is_active != 1) {
            Auth::logout();
            return back()->with([
                'account_deactivated' => 'Your account is deactivated! Please contact with Super Admin.'
            ]);
        }

        return next($request);
    }


 protected function ActivityLastLogin(Request $request, $user)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_seen = now();
            $user->save();

        UserLogin::create([
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'browser' => Browser::browserName(),
            'os' => Browser::platformName(),
            'token' => \session()->getId(),
            'login_at' => Carbon::now(),
            'location' => Location::get($request->ip())
             ]);

        }
    }




public function logout(Request $request)
    {
        if (Auth::check()) {
             $roles = Auth::user()->roles->first()->id;
             if ($roles != 1) {
                $login = UserLogin::where('user_id', Auth::id())->where('status', 1)->latest()->first();
                if ($login) {
                    $login->status = 0;
                    $login->logout_at = Carbon::now();
                    $login->save();
                }
            }
            Auth::logout();
            Session::flush();
        }

        return redirect('/');
    }



}
