<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['posts'] = Post::where('user_id',Auth::id())->orderBy('created_at','desc')->paginate(5);
        return view('post.dashboard',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $response = Post::setAuthId(Auth::id())->createPost($request->validated());

        if ($response['status'] === 'success') {
            flash()->success('success',$response['message']);
            return redirect()->route('posts.index');
        }
        flash()->error('error',$response['message']);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::where('user_id',Auth::id())->where('id',$id)->first();
        if (!$post){
            flash()->error('error',"Post not found");
            return redirect()->route('posts.index');
        }
        return view('post.post_details', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::where('user_id',Auth::id())->where('id',$id)->first();
        if (!$post) {
            flash()->error('Error','You are not authorized to access this page');
            return redirect()->back();
        }
        return view('post.add',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $response = Post::updatePost($request->all(), $id);
        if ($response['status'] === 'success') {
            flash()->success('success',$response['message']);
            return redirect()->route('posts.index');
        }
        flash()->error('error',$response['message']);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        flash()->success('success', 'Post disabled successfully.');
        return redirect()->route('posts.index');
    }
}
