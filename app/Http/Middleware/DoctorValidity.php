<?php

namespace App\Http\Middleware;

use App\Models\Doctor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DoctorValidity
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
        $doctor=DB::table('doctors')->where('userId',Auth::user()->id)->get()[0];
        if($doctor->docStatus=='Invalid'){
            return redirect()->route('doctor.invalid',$doctor->userId);
        }
        else{
            return $next($request);
        }
    }
}
