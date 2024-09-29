<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StorePostRequest;
use App\Http\Requests\User\UpdatePostRequest;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $posts = Post::with('user', 'comments')->where('user_id', auth()->user()->id)->get();
        return view('page.my-post.index', compact('posts'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.my-post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $request['user_id'] = auth()->user()->id;
        $request['post_date'] =  Carbon::parse($request->input('post_date'))->format('Y-m-d');
        $post = Post::create($request->all());
        if ($post){
            session()->flash('success', __('Article created successfully'));
        }else{
            session()->flash('error', __('Article created unsuccessfully'));
        }
        return redirect()->route('user.my-post');

    }
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
