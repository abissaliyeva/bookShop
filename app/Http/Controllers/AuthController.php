<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\WelcomeEmail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->hasRole('admin'))     return redirect()->route('admin.dashboard');
            if ($user->hasRole('manager'))   return redirect()->route('manager.dashboard');
            if ($user->hasRole('moderator')) return redirect()->route('moderator.dashboard');

            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors(['email' => __('messages.wrong_credentials')])
             ->withInput($request->except('password'));
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'     => '',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $user->assignRole($request->role);
        $user->assignRole('customer');

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeEmail($user));

        Auth::login($user);
        $request->session()->regenerate();

        if($request->role === 'manager') {
            return redirect()->route('manager.dashboard')
                             ->with('success', 'Welcome to the Book Shop!');
        }

        return redirect()->route('customer.dashboard')
                 ->with('success', __('messages.welcome_msg'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
                 ->with('success', __('messages.logged_out'));
    }
}