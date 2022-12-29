<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,String $role)
    {
        $roles = explode("|", $role);

        foreach($roles as $role)
        {
            if(Auth::user()->role == trim($role))
                return $next($request);
        }

        return redirect('/home') ->with('danger', "You are not allowed to access this section under your role of ".Auth::user()->role);    }
}
