<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:admin.post.view', ['only' => ['index', 'show']]);
        $this->middleware('can:admin.post.create', ['only' => ['create', 'store']]);
        $this->middleware('can:admin.post.edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:admin.post.delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->paginate(10);
        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.post.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $request['post_date'] =  Carbon::parse($request->input('post_date'))->format('Y-m-d');
        $post = Post::create($request->all());
        if ($post){
            session()->flash('success', __('Article created successfully'));
        }else{
            session()->flash('error', __('Article created unsuccessfully'));
        }
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $users = User::all();
        return view('admin.post.edit', compact('users', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request['post_date'] =  Carbon::parse($request->input('post_date'))->format('Y-m-d');
        $post->update($request->all());
        session()->flash('success', __('Article updated successfully'));
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        session()->flash('success', __('Article deleted successfully'));
        return redirect()->route('admin.posts.index');
    }
}
