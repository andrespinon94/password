<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
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
        
        $user->register($request);

        $data_token = [
            "email" => $request->email,
        ];

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
    public function show(Data_token $data_token)
    {
        
        $user = User::where('email',$data_token->email)->first();
        return response()->json([
            "user" => $user
        ], 201);
        
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
        //
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
        $data_token = [
            "email" => $request->email,
        ];
        
 $user = User::where($data_token)->first();
       
        if($request->password == $user->password){

            $token = new Token($data_token);
                $tokenEncoded = $token->encode();

                return response()->json(["token" => $tokenEncoded],201);
        }


 return response()->json (["Error"=>"No se ha encontrado"],401);

    }
}
