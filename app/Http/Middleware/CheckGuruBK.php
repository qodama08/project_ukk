<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckGuruBK
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if (!$user) {
            abort(403);
        }

        // Check jika user punya role guru_bk
        if ($user->roles && $user->roles()->where('nama_role', 'guru_bk')->exists()) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
