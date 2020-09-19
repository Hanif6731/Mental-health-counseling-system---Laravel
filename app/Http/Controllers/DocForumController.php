<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocForumController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('doctor.forum.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post=new Forum();
        $post->post=$request->post;
        $post->userId=Auth::user()->id;
        $post->save();
        return response()->json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show($forum)
    {
        $forum=DB::table('forums')
            ->join('users','forums.userId','=','users.id')
            ->orderByDesc('fpid')
            ->get();
//        $forum=DB::select(DB::raw(
//            'SELECT DISTINCT forums.*, users.*, COUNT(*) as cnt FROM comments
//JOIN forums on comments.postId=forums.fpid
//JOIN users on forums.userId=users.id GROUP BY postId ORDER by fpid DESC'));
//        $data = Forum::join('comments', function($join){
//            $join->on('comments.postId', '=', 'forums.id');
//            })->groupBy('comments.postId')
//                    ->orderBy( DB::raw('COUNT(comments.postId)'), 'desc' )
//                    ->select('posts.*')->
//        $posts=Forum::join('comments',function ($join){
//            $join->on('comments.postId','=','forums.fpid');
//        })->groupby('comments.postId')
//            ->orderby(DB::raw('COUNT(comments.postId)','desc'))
//            ->get();
        return response()->json($forum);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function edit(Forum $forum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forum $forum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum)
    {
        //
    }
}
