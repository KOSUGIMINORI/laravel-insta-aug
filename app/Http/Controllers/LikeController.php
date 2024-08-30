<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    private $like;
    public function __construct(Like $like)
    {
        $this->like = $like;
    }

    public function store(Request $request, $post_id)
    {
        $this->like->user_id = auth()->user()->id;
        $this->like->post_id = $post_id;
        $this->like->save();

        return back();
    }

    public function destroy($post_id)
    {
        
        $this->like->where('post_id', $post_id)->where('user_id', auth()->user()->id)-> delete();
        return back();
    }
}
