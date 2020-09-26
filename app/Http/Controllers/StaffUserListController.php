<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequests;
use App\Models\User;
use Carbon\Carbon;
use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class StaffUserListController extends Controller
{
    function index(Request $request){

        $users = DB::table('users')->get();
        return view('staff.userList.index')->with('users', $users);
    }


    public function delete($userList,$id){

        $user = User::find($id);
        return view('staff.userList.delete')->with('user', $user);

    }


    function destroy(Request $request){
        $id=$request->id;
        if(User::destroy($id)){
            return redirect()->route('staff.userList.index',Auth::user()->id);
        }else{
            return redirect()->route('staff.userList.delete', $id);
        }
    }


    public function search(Request $request,$str){
        $userId=$request->session()->get('userId');
        $response=Http::get('http://localhost:3000/search/'.$userId.'/'.$str);
        return $response->json();
    }

}
