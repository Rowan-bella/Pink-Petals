<?php
namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Login Form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Check Email and Password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'အီးမေးလ် သို့မဟုတ် စကားဝှက် မှားယွင်းနေပါသည်။',
            ])->onlyInput('email');
        }

        // Login
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // Get Role from Database
        $role = strtolower($user->role);

        // Admin and Manager
        if ($role === 'admin' || $role === 'manager') {
            return redirect()->route('admin.dashboard');
        }

        // Staff
        if ($role === 'staff') {
            return redirect()->route('admin.categories');
        }

        // Normal User
        return redirect()->route('home');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // Register Form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('login')
            ->with('success', 'အကောင့်ဖွင့်ခြင်း ပြီးမြောက်ပါပြီ။ Login ဝင်နိုင်ပါပြီ။');
    }
}
