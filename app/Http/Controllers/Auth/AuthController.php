<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirect based on user role
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'tenant' => redirect()->route('tenant.dashboard'),
                'seeker' => redirect()->route('seeker.dashboard'),
                default => redirect()->route('public.home')
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        return redirect()->route('login')->with('message', 'Fitur pendaftaran tidak tersedia. Silakan hubungi admin untuk membuat akun.');
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        return redirect()->route('login')->with('message', 'Fitur pendaftaran tidak tersedia. Silakan hubungi admin untuk membuat akun.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.home');
    }
}
