<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsManager
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Kiểm tra user có phải trưởng phòng không
        if (!$user || !$user->employee || $user->employee->position->name !== 'Trưởng phòng') {
            return redirect()->route('login')->with('error', 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}
