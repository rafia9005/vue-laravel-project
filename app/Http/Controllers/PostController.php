<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::all();
        return PostResource::collection($post);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => 'required|string|max:255',
            "news_content" => 'required|string'
        ]);

        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $authorId = Auth::id();


        $post = new Post();
        $post->title = $request->title;
        $post->news_content = $request->news_content;
        $post->author = $authorId;
        $post->created_at = now();

        $post->save();

        return response()->json([$post], 201);
    }
    public function delete($id)
    {
        $postDelete = Post::find($id);

        if (!$postDelete){
            return response()->json(['message' => "Post not found"]);
        }
        $postDelete->delete();

        return response()->json(['message' => "succes delete"]);
    }
    public function show($id)
    {
        $post = Post::find($id);

       if ($post) {
        return response()->json($post);
       } else {
        return response()->json(['message' => 'not found']);
       }
    }
}
