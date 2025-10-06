<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $employee = Auth::user(); // giả sử đang login bằng Employee model
        if ($employee && $employee->role === 'admin') {
            return $next($request);
        }
        abort(403, 'Bạn không có quyền truy cập.');
    }
}
