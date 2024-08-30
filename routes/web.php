<?php

use App\Models\Follow;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;


Auth::routes();

Route::group(["middleware" => "auth"],function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::group(['prefix'=>'post', 'as'=>'post.'], function(){
        Route::get('create', [PostController::class, 'create'])->name('create');
        Route::post('store', [PostController::class, 'store'])->name('store');
        Route::get('show/{id}',[PostController::class, 'show'])->name('show'); 
        Route::get('edit/{id}', [PostController::class, 'edit'])->name('edit');
        Route::patch('update/{id}',[PostController::class, 'update'])->name('update');
        Route::delete('/delete/{id}',[PostController::class,'destroy'])->name('destroy');
        
    });

    Route::group(['prefix'=>'comment', 'as'=>'comment.'], function(){
        Route::post('store/{post_id}', [CommentController::class, 'store'])->name('store');
        Route::delete('/destroy/{comment_id}', [CommentController::class, 'destroy'])->name('destroy');

    });
    Route::group(['prefix'=>'profile', 'as'=>'profile.'], function(){
        Route::get('/show/{user_id}', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit/{user_id}', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/followers/{user_id}', [ProfileController::class, 'followers'])->name('followers'); // このルートを追加
        Route::get('/following/{user_id}', [ProfileController::class, 'following'])->name('following'); // このルートを追加
    });
    
    Route::group(['prefix'=>'like'], function(){
        Route::post('store/{post_id}', [LikeController::class, 'store'])->name('like');
        //Route::delete('destroy/{post_id}', [LikeController::class, 'destroy'])->name('unlike');
       
    });

    Route::group(['prefix'=>'follow', "as"=>"follow."], function(){
        Route::post('follow/{following_id}', [FollowController::class, 'store'])->name('store');
        Route::delete('follow/{following_id}', [FollowController::class, 'destroy'])->name('destroy');
       
    });

    Route::group(["prefix"=>"admin","as"=>"admin."],function(){
        Route::group(["prefix"=>"users","as"=>"users."], function(){
            Route::get('/index',[UsersController::class,'index'])->name('index');
            Route::delete('/{id}/deactivate',[UsersController::class,'deactivate'])->name('deactivate');
            Route::patch('/{id}/activate',[UsersController::class,'activate'])->name('activate');
        });

        Route::group(["prefix"=>"posts","as"=>"posts."], function(){
            Route::get('/index',[PostsController::class,'index'])->name('index');
            Route::delete('/{id}/unvisible',[PostsController::class,'unvisible'])->name('unvisible');
            Route::patch('/{id}/visible',[PostsController::class,'visible'])->name('visible');
        });

    });

    

    //Route::group(['prefix'=>'follow', "as"=>"follow."], function(){
        //Route::post('follow/{followers_id}', [FollowController::class, 'store'])->name('store');
        //Route::delete('follow/{followers_id}', [FollowController::class, 'destroy'])->name('destroy');
       
    //});


    // Routeを変更したときは、いつも "php artisan optimaze"　する。 

});
