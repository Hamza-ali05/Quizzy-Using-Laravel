<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;

class AuthController extends Controller
{
    // Show pages
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showLogoutPage()
    {
        return view('auth.logout');
    }

    // Register new member
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:members,email',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:student,admin'
        ]);

        $member = Member::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'student'
        ]);

        // Auto login
        Auth::login($member);
        return $member->role === 'admin'? redirect()->route('admin.dashboard'): redirect()->route('student.dashboard');
    }

    // Login member
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // ✅ Check role and redirect
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'student') {
                return redirect()->route('student.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['role' => 'Unauthorized role']);
            }
        }
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }
    // Logout member
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}

