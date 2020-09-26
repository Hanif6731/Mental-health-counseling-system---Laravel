<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(strtolower(Auth::user()->type)=='staff') {

            return $next($request);
        }
        else {
            $request->session()->flash('msg','Invalid Request');
            return redirect()->route('login');
        }
    }
}
