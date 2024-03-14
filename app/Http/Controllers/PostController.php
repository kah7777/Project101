<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use PhpParser\Node\Stmt\Return_;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts=Post::all();
        return view('post.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $data = request()->validate([
            'title'=>'required|min:10',
            'text'=>'required',
        ]);
        Post::create($data);
        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('post.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Post $post)
    {
        $data = request()->validate([
                'title'=>'required|min:10',
                'text'=>'text|required',
            ]);
        $post->update($data);
        return redirect('post.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('post.index');
    }
}
