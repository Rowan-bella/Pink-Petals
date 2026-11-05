<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Login Form
    public function showLoginForm(Request $request)
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'အီးမေးလ် သို့မဟုတ် စကားဝှက် မှားယွင်းနေပါသည်။',
            ])->onlyInput('email');
        }

        // Login ဝင်ခြင်း
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // 💡 URL (သို့) Request ထဲပါလာသော product_id ဖြင့် Cart ထဲသို့ ထည့်ခြင်း
        $productId = $request->input('product_id') ?? $request->query('product_id');

        if ($productId) {
            $product = Product::find($productId);

            if ($product) {
                $cart = session()->get('cart', []);
                
                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] += 1;
                } else {
                    $cart[$productId] = [
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => $product->image,
                        'quantity' => 1
                    ];
                }
                session()->put('cart', $cart);
                session()->save();
            }
        }

        // 💡 Normal User ဖြစ်ပါက Cart Page သို့ မပို့ဘဲ မူလကြည့်နေကျ Products Page သို့ တန်းပြန်ပို့မည်
        if (strtolower($user->role) === 'user') {
            return redirect()->intended(route('shop.products'));
        }

        // Role အလိုက် အခြားနေရာများသို့ ပို့ရန်
        $role = strtolower($user->role);
        if ($role === 'admin' || $role === 'manager') {
            return redirect()->route('admin.dashboard');
        }
        if ($role === 'staff') {
            return redirect()->route('admin.categories');
        }

        return redirect()->route('home');
    }
    // Logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
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