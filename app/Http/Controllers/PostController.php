<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\Category;




class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $post;
    private $category;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }
    
    public function index()
    {
        
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $all_categories = $this->category->all();

        return view('users.post.create')->with('all_categories', $all_categories);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->post->description = $request->description;
        // this code convert
        $this->post->image       = 'data:image/'.$request->image->extension().';base64,'.base64_encode(file_get_contents($request->image));
        $this->post->user_id     = auth()->user()->id;
        $this->post->save();


        // rewriting the 
        foreach($request->category as $category_id):
            $category_post[] = ["category_id"=>$category_id];
        endforeach;

        $this->post->category_post()->createMany($category_post);


        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $post = $this->post->findOrFail($id);

        return view('users.post.show')
                ->with('post', $post);
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = $this->post->findOrFail($id);

        // IF the AUTH user is NOT the owner of the post, redirect to homepage
        if (Auth::user()->id != $post->user->id){
            return redirect()->route('index');

        }

        $all_categories = $this->category->all();

        # GET ALL the category IDs of this POST then save it into an array.
        $selected_categories = [];
        foreach($post->category_post as $category_post){
            $selected_categories[] = $category_post->category_id;
        }

        return view('users.post.edit')
                ->with('post', $post)
                ->with('all_categories', $all_categories)
                ->with('selected_categories', $selected_categories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        # 1. VALIDATE the data from the form
        $request->validate([
            'category'     => 'required|array|between:1,3',
            'description'  => 'required|min:1|max:1000',
            'image'        => 'mimes:jpg,png,jpeg,gif|max:1048'
        ]);

        # 2. UPDATE the POST
        $post              = $this->post->findOrFail($id);
        $post->description = $request->description;

        // IF there is a new image
        if($request->image){
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode
            (file_get_contents($request->image));
        }

        $post->save();

        # 3. DELETE all records from category_post table that is related to this post
        $post->category_post()->delete();
        // category_post() ~~ eloquent relationship

        # 4. SAVE the new categories to the category_post table
        foreach($request->category as $category_id){
            $category_post[] = ['category_id' => $category_id];
        }

        $post->category_post()->createMany($category_post);
        // createMany() ~~ will insert to the table using an array.

        # 5. REDIRECT to Show Post page.
        return redirect()->route('post.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->post->destroy($id);

        return redirect()->route('index');
        
    }


}
