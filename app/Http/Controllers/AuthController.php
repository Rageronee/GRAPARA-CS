<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Redirect to home with 'login' parameter to open modal
    public function showLoginForm()
    {
        return redirect('/?action=login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Check if user exists first
        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            return redirect('/?action=login')->withErrors([
                'login_error' => 'Username tidak ditemukan.',
            ])->withInput();
        }

        if (!Auth::attempt($credentials)) {
            return redirect('/?action=login')->withErrors([
                'login_error' => 'Password salah.',
            ])->withInput();
        }

        $request->session()->regenerate();
        // Admins/Staff go to Dashboard, Customers stay on landing page (or user dashboard)
        if (Auth::user()->role === 'customer') {
            return redirect('/')->with('message', 'Login berhasil! Silakan ambil antrian.');
        }
        return redirect()->intended('dashboard');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'password.min' => 'Password minimal 8 karakter!',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer', // Auto-assign customer role
        ]);

        Auth::login($user);

        return redirect('/')->with('message', 'Akun berhasil dibuat! Silakan pilih layanan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
