<?php
namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

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

        if ($request->filled('product_id')) {
            session(['pending_product_id' => $request->input('product_id')]);
        }
        if ($request->filled('quantity')) {
            session(['pending_quantity' => $request->input('quantity')]);
        }
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
        $productId = $request->input('product_id') ?? $request->query('product_id') ?? session('pending_product_id');
        $quantity = (int) ($request->input('quantity') ?? $request->query('quantity') ?? session('pending_quantity') ?? 1);

        if ($productId) {
            $product = Product::find($productId);

            if ($product) {
                $userId = auth()->id();
                $cartItem = CartItem::where('user_id', $userId)
                                    ->where('product_id', $productId)
                                    ->first();

                $totalQty = $cartItem ? ($cartItem->quantity + $quantity) : $quantity;

                if ($totalQty <= $product->stock) {
                    if ($cartItem) {
                        $cartItem->update(['quantity' => $totalQty]);
                    } else {
                        CartItem::create([
                            'user_id' => $userId,
                            'product_id' => $productId,
                            'quantity' => $quantity
                        ]);
                    }
                }
                session()->forget(['pending_product_id', 'pending_quantity']);
            }
        }
        if (strtolower($user->role) === 'user') {
            return redirect()->intended(route('shop.products'));
        }

        $role = strtolower($user->role);
        if ($role === 'admin' || $role === 'manager') {
            return redirect()->route('admin.dashboard');
        }
        if ($role === 'staff') {
            return redirect()->route('admin.categories');
        }

        return redirect()->route('home');
    }
    public function logout(Request $request)
    {
        if (auth()->check()) {
            CartItem::where('user_id', auth()->id())->delete();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 1 Jan 2000 00:00:00 GMT');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }
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