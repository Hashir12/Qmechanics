<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title','content','user_id'];
    private static $parent_id;
    public static function setAuthId($id)
    {
        self::$parent_id = $id;
        return new self;
    }

    public function createPost(array $data)
    {
        try {
            $newPost = Post::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'user_id' => Auth::id(),
            ]);

            if (!$newPost) {
                throw new Exception("Failed to create post.");
            }

            return ['status' => 'success', 'message' => 'Post created successfully.'];
        } catch(\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public static function updatePost($data, $id)
    {
        try {
            $post = self::find($id);
            if (!$post) {
                throw new Exception("Post not found.");
            }

            $post->title = $data['title'];
            $post->content = $data['content'];
            $post->save();
            return ['status' => 'success', 'message' => 'Post updated successfully.'];
        } catch(Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
