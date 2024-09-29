<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StorePostRequest;
use App\Http\Requests\User\UpdatePostRequest;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:user.post.view', ['only' => ['index', 'show']]);
        $this->middleware('can:user.post.create', ['only' => ['create', 'store']]);
        $this->middleware('can:user.post.edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:user.post.delete', ['only' => ['destroy']]);
    }
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

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('page.my-post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request['post_date'] =  Carbon::parse($request->input('post_date'))->format('Y-m-d');
        $post->update($request->all());
        session()->flash('success', __('Article updated successfully'));
        return redirect()->route('user.my-post');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        session()->flash('success', __('Article deleted successfully'));
        return redirect()->route('user.my-post');
    }
}
