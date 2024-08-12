<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use PhpParser\Node\Stmt\Return_;
use DB;


class PostController extends Controller
{
    public function index()
    {
        $posts=Post::with('comments')->get();
        return PostResource::collection($posts);
    }

    public function store()
    {
        $data = request()->validate([
            'title'=>'required|min:10',
            'text'=>'required',
            'image'=>'required|image|max:2048',
        ]);
        $post = \DB::transaction(function()use($data){
            $post= Post::create([
                'title'=>$data['title'],
                'text'=>$data['text'],
                'user_type'=>User::class,
                'user_id'=>request()->user()->id,
               ]);
               $post->addMediaFromRequest("image")->toMediaCollection(Post::POST_IMAGE);
               return $post;
        });
        return PostResource::make($post);
    }

    public function show(Post $post)
    {
        $post->load('comments');
        return PostResource::make($post);
    }

    public function update(Post $post)
    {
        $data = request()->validate([
            'title'=>'required|min:10',
            'text'=>'required',
            'imgae'=>'required|image|max:2048',
            ]);
        $post->update($data);
        return PostResource::make($post);
    }

    public function destroy(Post $post)
    {
       return $post->delete();
    }
}
