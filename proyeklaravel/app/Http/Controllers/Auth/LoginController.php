<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    $user = User::with(['roleUser' => function($query) {
        $query->where('status', 1);
    }, 'roleUser.role'])
        ->where('email', $request->input('email'))
        ->first();

    if (!$user) {
        return redirect()->back()
            ->withErrors(['email' => 'Email tidak ditemukan.'])
            ->withInput();
    }

    // Cek password
    if (!Hash::check($request->password, $user->password)) {
        return redirect()->back()
            ->withErrors(['password' => 'Password salah.'])
            ->withInput();
    }

    $namaRole = Role::where('idrole', $user->roleUser[0]->idrole ?? null)->first();

    // Login user ke session
    Auth::login($user);

    // Simpan session user
   $request->session()->put([
    'user_id' => $user->iduser,
    'user_name' => $user->nama,
    'user_email' => $user->email,
    'user_role' => (int)($user->roleUser[0]->idrole ?? 0),
    'user_role_name' => $namaRole->nama_role ?? 'user',
    'user_status' => $user->roleUser[0]->status ?? 'active'
]);


    $userRole = $user->roleUser[0]->idrole ?? null;
    // dd($userRole);
    switch ($userRole) {
        case '1':
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
        case '2':
            return redirect()->route('dokter.dashboard')->with('success', 'Login berhasil!');
        case '3':
            return redirect()->route('perawat.dashboard')->with('success', 'Login berhasil!');
        case '4':
            return redirect()->route('resepsionis.dashboard')->with('success', 'Login berhasil!');
        default:
            return redirect()->route('pemilik.dashboard')->with('success', 'Login berhasil!');
    }
}
}

