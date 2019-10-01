<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use App\Models\Taggable;
use Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return response ($user,200);
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
            'email' => 'required|unique:users|max:191',
            'password'=> 'required|min:5|max:20',
            'taggables' => 'nullable',
            'taggables.*.tag_id'=> 'required|exists:tags,id',
            'taggables.*.taggable_type'=> 'required|max:191'
        ],[
            'name.required' => 'The name field is required',
            'name.max' => 'The maximum size must be 191 characters in name field',
            'email.required' => 'The email field is required',
            'email.unique' => 'This email already registered',
            'email.max' => 'The maximum size must be 191 characters in email field',
            'password.min' => 'The minimum size must be 5 characters in password field',
            'password.max' => 'The maximum size must be 20 characters in password field',
            'password.required' => 'The minimum size must be 5 characters in password field',
            'taggables.*.tag_id.required' => 'select a tag please',
            'taggables.*.tag_id.exists' => 'This a tag no exists in the system',
            'taggables.*.taggable_type.required' => 'Taggable type is required',
            'taggables.*.taggable_type.max' => 'he maximum size must be 191 characters in taggable type field',
        ]);

        if($validator->fails()){
    		return response(["errors"=>$validator->errors(), 'msg'=>'unprocessed request'], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        if(isset($request->taggables) && !empty($request->taggables)){
            $taggables = $request->taggables;
            for($i=0; $i<count($taggables); $i++){
                $taggable = new Taggable();

                $taggable->user_id = $user->id;
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
        $user = User::with('taggables')->find($id);

        if(empty($user)){
            return response(['msg'=>'Resource not found'], 404);
        }

        return response($user, 200);
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

        $user = User::find($id);

        if(empty($user)){
            return response(['msg'=>'Resource not found'], 404);
        }

        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'password'=> 'nullable|min:5|max:20',
            
        ],[
            'name.required' => 'The name field is required',
            'name.max' => 'The maximum size must be 191 characters in name field',
            'email.required' => 'The email field is required',
            'email.max' => 'The maximum size must be 191 characters in email field',
            'email.min' => 'The minimum size must be 5 characters in email field',
            'password.min' => 'The minimum size must be 5 characters in password field',
            'password.max' => 'The maximum size must be 20 characters in password field',
        ]);

        if($validator->fails()){
    		return response(["errors"=>$validator->errors(), 'msg'=>'unprocessed request'], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
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
        $user = User::find($id);

        if(empty($user)){
            return response(['msg'=>'Resource not found'], 404);
        }

        $user->delete();
        return response(['mensaje'=>'Deleted Correctly'], 202);
    }
}
