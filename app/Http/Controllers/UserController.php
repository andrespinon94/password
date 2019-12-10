<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\Password;
use App\Helpers\Token;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        
        $user_reapeted = User::where('email', $request->email)->first();

        if (isset($user_reapeted)) 
        {
            return response()->json(["repetido" => "usuario  con ese email ya existe"],400);
        }
        $user->register($request);

        $data_token = ["email" => $request->email];

        $token = new Token($data_token);
        $tokenEncode = $token->encode();
    
        return response()->json(["token" => $tokenEncode], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {       
        $data_array = array();
        $user = User::where('email', $request->data_token->email)->first();
        $categories = Category::where('id_user', $user->id)->get();

        if (isset($categories)) 
        {
            array_push($data_array,$user,$categories);

            foreach ($categories as $key => $category) 
            {
                $passwords = Password::where('id_category',$category->id)->get();
                array_push($data_array, $passwords);
            }
                 
            return response()->json(["data" => $data_array],200);

        } else {
            return response()->json(["Error" => "no categories and  passwords to show "]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $user = User::where('email',$request->new_email)->first();

        if (isset($user)) 
        {
            return response()->json(["error" => "email already exist in database"], 400);
        }

        $user = User::where('email',$request->data_token->email)->first();

        $user->email = $request->new_email;
        $user->name = $request->new_name;
        $user->password = $request->new_password;
        $user->update();

        return response()->json(["Success" => "user edited"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function login(Request $request)
    {
        $data_token = ["email" => $request->email];
        
        $user = User::where($data_token)->first();
       
        if($request->password == $user->password)
        {
            $token = new Token($data_token);
            $tokenEncoded = $token->encode();
            return response()->json(["token" => $tokenEncoded],200);
        }
    return response()->json (["Error"=>"user is not registered"],401);
    }
}
