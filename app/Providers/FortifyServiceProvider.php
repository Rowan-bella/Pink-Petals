<?php
namespace App\Providers;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\CartItem; 
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;
class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });
         
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });
        $this->app->singleton(LoginResponse::class, function () {
            return new class implements LoginResponse {
                public function toResponse($request)
                {
                    $productId = $request->input('product_id');
                    $quantity = (int) $request->input('quantity', 1);
                    if ($productId && auth()->check()) {
                        $product = \App\Models\Product::find($productId);
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
                        }
                    }

                    $user = auth()->user();

                    if ($user->hasRole(['admin', 'manager'])) {
                        return redirect()->route('admin.dashboard');
                    }

                    if ($user->hasRole('staff')) {
                        return redirect()->route('admin.orders');
                    }

                    return redirect()->route('shop.products');
                }
            };
        });
        $this->app->singleton(LogoutResponse::class, function () {
            return new class implements LogoutResponse {
                public function toResponse($request)
                {
                    if (auth()->check()) {
                        CartItem::where('user_id', auth()->id())->delete();
                    }

                    auth()->guard('web')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('home')
                        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sat, 1 Jan 2000 00:00:00 GMT');
                }
            };
        });

        $this->app->singleton(RegisterResponse::class, function () {
            return new class implements RegisterResponse {
                public function toResponse($request)
                {
                    auth()->guard('web')->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('login');
                }
            };
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId()).'|'.$request->ip()
            );
        });
    }
}