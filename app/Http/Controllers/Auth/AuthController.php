<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration form submission
    public function register(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create a new user record in the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Log the user in immediately after registration
        Auth::login($user);

        // Redirect to homepage with a success message
        return redirect()->intended('/tasks');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login form submission
    public function login(Request $request)
    {
        // Validate login credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log the user in with credentials
        if (Auth::attempt($credentials)) {
            // Regenerate session to protect against fixation
            $request->session()->regenerate();

            // Redirect to tasks page
            return redirect()->intended('/tasks');
        }

        // If authentication fails, redirect back with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Log the user out
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login page
        return redirect('/login');
    }
}
