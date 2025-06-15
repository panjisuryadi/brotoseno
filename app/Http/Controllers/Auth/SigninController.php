<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserLogin;
use Brian2694\Toastr\Facades\Toastr;
use Browser;
use Carbon\Carbon;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Stevebauman\Location\Facades\Location;
use Cookie;
use Illuminate\Support\Facades\Mail;


class SigninController extends Controller
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


    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {


        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : $path;
    }


    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request),
            $this->maxAttempts()
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter()->hit(
            $this->throttleKey($request),
            $this->decayMinutes()
        );
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [Lang::get('auth.throttle', ['seconds' => $seconds])],
        ])->status(429);
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        $this->limiter()->clear($this->throttleKey($request));
    }

    /**
     * Fire an event when a lockout occurs.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function fireLockoutEvent(Request $request)
    {
        event(new Lockout($request));
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input($this->username())) . '|' . $request->ip();
    }

    /**
     * Get the rate limiter instance.
     *
     * @return \Illuminate\Cache\RateLimiter
     */
    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    /**
     * Get the maximum number of attempts to allow.
     *
     * @return int
     */
    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
    }

    /**
     * Get the number of minutes to throttle for.
     *
     * @return int
     */
    public function decayMinutes()
    {
        return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1;
    }


    public function showLoginForm()
    {
    return view('login.login');

    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {


        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            // if (Auth::user()->status == 0) {
            //     Auth::logout();
            //     Toastr::error('Your account has been disabled !', 'Failed');
            //     return back();
            // }

            //  if (Auth::user()->status == 2) {
            //     Auth::logout();
            //     Toastr::error('Your account has been Bloked !', 'Failed');
            //     return back();
            // }

              //  $roles = Auth::user()->roles->first()->id;
              //  if ($roles != 1) {
              //   if (!$this->multipleLogin($request)) {
              //       Toastr::error('Your Account is already logged in, into ' . setting('device_limit') . ' devices', 'Error!');
              //       return back();
              //   }
              // }

            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }



    protected function validateLogin(Request $request)
    {

     $messages = [
                'email.required'=> 'Email Tidak boleh Kosong',
            ];

        $rules = [
                $this->username() => 'required|email|exists:users,email',
                'password' => 'required|string'
            ];
         $this->validate($request, $rules, $messages);
      }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
         Toastr::success('Login Sukses !', 'success');
        activity()->log(' '.auth()->user()->name.' Login Sukses');
        $goto = \session('redirectTo') ?? redirect()->intended($this->redirectPath())->getTargetUrl();
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        return $this->authenticated($request,
            $this->guard()->user())
            ?: redirect()->to($goto);
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {

        if (Auth::check()) {
            $user = Auth::user();
            $user->last_seen = now();
            $user->save();
        }
    }



    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
        {

               $user = User::where('email',$request->email)->first();
                if($user){
             if($user && !Hash::check($request->password, $user->password) ){
               $time_attempt = session()->get('time_attempt', 0);
               session()->put('time_attempt', $time_attempt + 1);
                if($time_attempt >= 3){
                    $user->status = 2;
                    $user->save();
                    $cookie = session()->forget('time_attempt');
                    Toastr::error(''.$time_attempt.' Gagal Login ! ,Akun anda di blok', 'Warning');
                    return back();

                }
                $time_attempt = session()->get('time_attempt', 0);
                    throw ValidationException::withMessages([
                        'password' => __('auth.password'),
                    ]);
                }
                 else{
                    Toastr::error('Your account '.$time_attempt.' !', 'Warning');
                    throw ValidationException::withMessages([
                     'email' => __('auth.failed'),
                ]);
                }
             }

        }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';

    }

    /**
     * The user has logged out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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



  public function multipleLogin($request)
    {
        $device_limit = setting('device_limit');
        $logins = DB::table('user_logins')
            ->where('status', '=', 1)
            ->where('user_id', '=', Auth::id())
            ->latest()
            ->get();
        if ($device_limit != 0) {
            if (count($logins) == $device_limit) {
                Auth::logout();
                return false;
            }
        }
        $login = UserLogin::create([
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'browser' => Browser::browserName(),
            'os' => Browser::platformName(),
            'token' => \session()->getId(),
            'login_at' => Carbon::now(),
            'location' => Location::get($request->ip())
        ]);
        \session()->put('login_token', $login->token);
        return true;
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
