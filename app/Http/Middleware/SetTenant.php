<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SetTenant
{
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();
        $domain = DB::table('domains')->where('domain', $host)->first();

        if ($domain) {
            Session::put('tenant_id', $domain->tenant_id);
        } else {
            abort(403, 'Domain không hợp lệ');
        }

        return $next($request);
    }
}
