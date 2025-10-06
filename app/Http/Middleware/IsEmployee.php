<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEmployee
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Kiểm tra có employee và position không phải trưởng phòng
        if ($user && $user->employee?->position?->name !== 'Trưởng phòng') {
            return $next($request);
        }

        abort(403, 'Bạn không có quyền truy cập.');
    }
}
