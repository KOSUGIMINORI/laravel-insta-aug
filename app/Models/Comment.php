<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    ////create a relationship to display the user associated with this comment

    # To get the info of the owner of the comment
    public function user(){
        return $this->belongsTo(User::class);
    }





    //protected $fillable = [
        //'comment',
        //'comment_id',
        //'user_id',
    //];

    //public function comment(){
        //return $this->belongTo('App\Http\Models\Comment');

    //}

    

}
