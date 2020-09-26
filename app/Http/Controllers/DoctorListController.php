<?php

namespace App\Http\Controllers;


use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorListController extends Controller
{
    public function index(Request $request)
    {
        $doctorList = DB::table('doctors')
        ->join('users','doctors.userId','=','users.id')
        ->get();
        //dd($doctorList);
        return view('admin.doctorList.index')->with('users', $doctorList);

    }
    public function ban(Request $request){
        $id=$request->docUId;
        $doctorList= DB::table('doctors')->where('userId', $id)->update(array('docStatus' => 'Banned'));

        return redirect()->route('admin.doctorList.index',Auth::user()->id);
    }

    public function valid(Request $request){
        $id=$request->docUId;
        $doctorList= DB::table('doctors')->where('userId', $id)->update(array('docStatus' => 'Valid'));

        return redirect()->route('admin.doctorList.index',Auth::user()->id);
    }
}
