<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorProfileCompletion
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
        $doctor=DB::table('doctors')
            ->where('userId','=',Auth::user()->id)
            ->get();
        //print_r($doctor);
        if(count($doctor)) {

            return $next($request);
        }
        else {
            $request->session()->flash('msg','Please Complete Your Profile');
            return redirect()->route('doctor.create');
        }

    }
}
