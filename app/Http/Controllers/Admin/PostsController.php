<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    private $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $all_posts = $this->post->withTrashed()->latest()->get();
        
        return view('admin.posts.index')->with('all_posts',$all_posts);
    }

    public function unvisible($id){
        $post = $this->post->findOrFail($id);
        $post->delete();

        return back();
    }

    public function visible($id){
        $post = $this->post->withTrashed()->findOrFail($id);
        $post->restore();
        
        return back();
    }
}
