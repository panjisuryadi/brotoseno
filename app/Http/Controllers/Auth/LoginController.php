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

    protected function authenticated(Request $request, $user)
    {
        // 1) Simpan kredensial tenant di session (belum switch)
        session([
            'tenant_db' => [
                'database' => $user->db,
                'username' => $user->db_username,
                // decrypt kalau kamu simpan terenkripsi:
                // 'password' => \Crypt::decryptString($user->db_password),
                'password' => $user->db_password,
                'host'     => config('database.connections.mysql.host'),
                'port'     => config('database.connections.mysql.port'),
            ],
        ]);

        // 2) Jalankan log/aktivitas yang HARUS ke central dulu
        $this->ActivityLastLogin($request, $user);

        // 3) Cek status aktif (masih di central, aman)
        if ($user->is_active != 1) {
            // kalau nonaktif, bersihkan jejak tenant
            session()->forget('tenant_db');
            Auth::logout();

            return back()->with([
                'account_deactivated' => 'Your account is deactivated! Please contact the Super Admin.'
            ]);
        }

        // 4) BARU aktifkan koneksi tenant untuk request ini (opsional)
        // app(\App\Http\Middleware\UseTenantConnection::class)
        //     ->handle($request, fn () => null);

        // NOTE: redirectTo kamu sudah di-set ke url()->previous()
        // biarkan trait meng-handle redirect.
    }



 protected function ActivityLastLogin_bu(Request $request, $user)
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


protected function ActivityLastLogin(Request $request, $user)
{
    if (!Auth::check()) return;

    // Pastikan model User pusat memang koneksinya 'mysql'
    $u = Auth::user();
    $u->setConnection('mysql'); // jaga-jaga bila koneksi sudah terswitch di tempat lain
    $u->last_seen = now();
    $u->save();

    // Location::get() return object — bagusnya simpan JSON string
    $loc = \Stevebauman\Location\Facades\Location::get($request->ip());

    // Pastikan model UserLogin dipin ke central (lihat poin #2)
    \Modules\UserLogin\Models\UserLogin::create([
        'user_id'   => Auth::id(),
        'ip'        => $request->ip(),
        'browser'   => \Browser::browserName(),
        'os'        => \Browser::platformName(),
        'token'     => session()->getId(),
        'login_at'  => \Carbon\Carbon::now(),
        'location'  => $loc ? json_encode([
            'country' => $loc->countryName ?? null,
            'region'  => $loc->regionName ?? null,
            'city'    => $loc->cityName ?? null,
            'lat'     => $loc->latitude ?? null,
            'lon'     => $loc->longitude ?? null,
        ]) : null,
    ]);
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
