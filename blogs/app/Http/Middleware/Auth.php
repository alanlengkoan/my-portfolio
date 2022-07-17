<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Closure;

class Auth extends Controller
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('roles') && checking_session($this->session)) {
            return $next($request);
        }
        return redirect('/');
    }
}
