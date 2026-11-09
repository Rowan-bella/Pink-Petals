<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
    
        if (!auth()->check()) {
            return redirect('/login');
        }
        $userRole = strtolower(auth()->user()->role); 
        $roles = array_map('strtolower', $roles);
        if (in_array($userRole, $roles)) {
            return $next($request);
        }
        abort(403, 'ဒီစာမျက်နှာကို ဝင်ရောက်ခွင့် မရှိပါရှင်။');
    }
}