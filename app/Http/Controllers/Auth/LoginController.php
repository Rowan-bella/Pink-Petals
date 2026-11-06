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

        // 💡 1. Login မဝင်ခင် Request ထဲပါလာရင် Session ထဲ သိမ်းမည်
        if ($request->filled('product_id')) {
            session(['pending_product_id' => $request->input('product_id')]);
        }
        if ($request->filled('quantity')) {
            session(['pending_quantity' => $request->input('quantity')]);
        }

        // Login ဝင်ခြင်း နှင့် Session Regenerate လုပ်ခြင်း
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // 💡 2. Request (သို့) Session ထဲမှ product_id နှင့် quantity ကို ရှာဖွေခြင်း
        $productId = $request->input('product_id') ?? $request->query('product_id') ?? session('pending_product_id');
        $quantity = $request->input('quantity') ?? $request->query('quantity') ?? session('pending_quantity') ?? 1;

        if ($productId) {
            $product = Product::find($productId);

            if ($product) {
                $cart = session()->get('cart', []);
                
                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] += (int) $quantity;
                } else {
                    $cart[$productId] = [
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => $product->image,
                        'quantity' => (int) $quantity
                    ];
                }
                session()->put('cart', $cart);
                session()->save();

                // 💡 3. ထည့်ပြီးပါက Session ထဲမှ ယာယီတန်ဖိုးများကို ရှင်းထုတ်မည်
                session()->forget(['pending_product_id', 'pending_quantity']);
            }
        }

        // 💡 Normal User ဖြစ်ပါက Cart Page သို့မဟုတ် Products Page သို့ ပို့မည်
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