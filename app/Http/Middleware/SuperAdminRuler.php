<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\ApiController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminRuler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->tokenCan('superadmin')) {
            return $next($request);
        }else{
            throw new \Illuminate\Validation\UnauthorizedException();
        }
    }
}
