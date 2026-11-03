<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
    
        if (!auth()->check()) {
            return redirect('/login');
        }

        // User ရဲ့ role ကို ယူ၍ စာလုံးသေး (lowercase) ပြောင်းမည်
        $userRole = strtolower(auth()->user()->role); 
        
        // ပေးထားသော roles များကိုလည်း စာလုံးသေးပြောင်းမည်
        $roles = array_map('strtolower', $roles);

        // Role ကိုက်ညီမှု ရှိမရှိ စစ်ဆေးမည်
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // ခွင့်ပြုချက်မရှိလျှင် 403 Error ပြမည်
        abort(403, 'ဒီစာမျက်နှာကို ဝင်ရောက်ခွင့် မရှိပါရှင်။');
    }
}