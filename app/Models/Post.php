<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category_post(){
        return $this->hasMany(CategoryPost::class);
    }


    //// add relationship to display all comments associate with this post
    //public function all_comments(){
        //return $this->hasMany(Comment::class);
    //}

    # To get all the comments of a post
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function isLiked(){
        // CHECK IF YOU LIKED THE POST ALREADY
        return $this->likes()->where('user_id', auth()->user()->id)->exists();
    }
    // select * from likes where post_id = 15(post id) and user_id = 2(user id) ??? == TRUE

    
    
    
}
// CRUD - create, , update, delete
