<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminPermissionMiddleware
{
    public function handle($request, Closure $next, string $permission)
    {
        $admin = Auth::guard('admin')->user();

        // Superadmin bypasses all permission checks
        if ($admin && $admin->isSuperAdmin()) {
            return $next($request);
        }

        if (!$admin || !$admin->hasPermission($permission)) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
