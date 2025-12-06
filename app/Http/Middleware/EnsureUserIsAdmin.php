<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $isAdmin = ($user->role === 'admin') || ($user->roles()->where('nama_role','admin')->exists());

        if (!$isAdmin) {
            abort(403, 'Unauthorized - admin only');
        }

        return $next($request);
    }
}
