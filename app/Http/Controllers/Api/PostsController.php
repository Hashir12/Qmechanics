<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Exception;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $posts = Post::where('user_id', Auth::id())
                ->latest()
                ->paginate(5);

            return response()->json([
                'message' => 'Posts retrieved successfully.',
                'data' => PostResource::collection($posts),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error retrieving posts.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostRequest $request): JsonResponse
    {
        try {
            $newPost = Post::create([
                'title' => $request->input('title'),
                'content' => $request->input('post_content'),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'message' => 'Post created successfully.',
                'data' => new PostResource($newPost),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error creating post.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $post = Post::where('user_id', Auth::id())->findOrFail($id);
            return response()->json([
                'message' => 'Post retrieved successfully.',
                'data' => new PostResource($post),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Post not found.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error retrieving post.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PostRequest $request, string $id): JsonResponse
    {
        try {
            $post = Post::where('user_id', Auth::id())->findOrFail($id);

            $post->update([
                'title' => $request->input('title'),
                'content' => $request->input('post_content'),
            ]);

            return response()->json([
                'message' => 'Post updated successfully.',
                'data' => new PostResource($post),
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Post not found.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error updating post.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $post = Post::where('user_id', Auth::id())->findOrFail($id);
            $post->delete();

            return response()->json([
                'message' => 'Post deleted successfully.',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Post not found.',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error deleting post.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
