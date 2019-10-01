<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Post;
use App\Models\Taggable;
use App\Models\User;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::all();
        return response ($post,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'taggables' => 'nullable',
            'taggables.*.tag_id'=> 'required|exists:tags,id',
            'taggables.*.taggable_type'=> 'required|max:191'
        ],[
            'title.required' => 'The title field is required',
            'taggables.*.tag_id.required' => 'select a tag please',
            'taggables.*.tag_id.exists' => 'This a tag no exists in the system',
            'taggables.*.taggable_type.required' => 'Taggable type is required',
            'taggables.*.taggable_type.max' => 'he maximum size must be 191 characters in taggable type field',
        ]);

        if($validator->fails()){
    		return response(["errors"=>$validator->errors(), 'msg'=>'unprocessed request'], 422);
        }
        $user_id = User::resolveId();
        $post = new Post();
        $post->user_id = $user_id;
        $post->title = $request->title;
        $post->save();

        if(isset($request->taggables) && !empty($request->taggables)){
            $taggables = $request->taggables;
            for($i=0; $i<count($taggables); $i++){
                $taggable = new Taggable();

                $taggable->post_id = $post->id;
                $taggable->tag_id = $taggables[$i]['tag_id'];
                $taggable->taggable_type = $taggables[$i]['taggable_type'];
                $taggable->save();
            }
        }
        return response(['msg'=>'Created Correctly'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::with('taggables')->find($id);

        if(empty($post)){
            return response(['msg'=>'Resource not found'], 404);
        }

        return response($post, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if(empty($post)){
            return response(['msg'=>'Resource not found'], 404);
        }

        $validator = \Validator::make($request->all(), [
            'title' => 'required',
        ],[
            'title.required' => 'The title field is required',
        ]);

        if($validator->fails()){
    		return response(["errors"=>$validator->errors(), 'msg'=>'unprocessed request'], 422);
        }
        $user_id = User::resolveId();
        $post->user_id = $user_id;
        $post->title = $request->title;
        $post->save();
        return response(['msg'=>'Updated Correctly'], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(empty($post)){
            return response(['msg'=>'Resource not found'], 404);
        }

        $post->delete();
        return response(['mensaje'=>'Deleted Correctly'], 202);
    }
}
