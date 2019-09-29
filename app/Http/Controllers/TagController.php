<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Tag;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tag = Tag::all();
        return response ($tag, 200);
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
            'name' => 'required|max:191',
        ],[
            'name.required' => 'The name field is required',
            'name.max' => 'The maximum size must be 191 characters',            
        ]);

        if($validator->fails()){
    		return response(["errors"=>$validator->errors(), 'msg'=>'unprocessed request'], 422);
        }

        $tag = new Tag();
        $tag->name = $request->name;
        $tag->save();
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
        $tag = Tag::find($id);

        if(empty($tag)){
            return response(['msg'=>'Resource not found'], 404);
        }

        return response($tag, 200);
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
        $tag = Tag::find($id);

        if(empty($tag)){
            return response(['msg'=>'Resource not found'], 404);
        }

        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:191',
        ],[
            'name.required' => 'The name field is required',
            'name.max' => 'The maximum size must be 191 characters',            
        ]);
        
        if($validator->fails()){
    		return response(["errors"=>$validator->errors(), 'msg'=>'unprocessed request'], 422);
        }

        $tag->name = $request->name;
        $tag->save();
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
        $tag = Tag::find($id);

        if(empty($tag)){
            return response(['msg'=>'Resource not found'], 404);
        }

        $tag->delete();
        return response(['mensaje'=>'Deleted Correctly'], 202);

    }
}
