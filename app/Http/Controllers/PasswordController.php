<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Password;
use App\Category;
use App\User;

class PasswordController extends Controller
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
        
        $password = new Password();
        $email = $request->data_token->email;
        $user = User::where('email', $email)->first();
        $id_user = $user->id;
        $password_content = $request->password;
        $title = $request->title;
        $category_name = $request->category_name;
        $category = Category::where('id_user', $id_user)->where('name',$category_name)->first();
        
        if (!isset($category)) 
        {
            return response()->json([
                "message" => "Categoria no esta creada"
            ], 200);
        }

        $password->givePassword($password_content,$category_name,$category);

        return response()->json([
            "message" => "Contrasena Creada"
        ], 200);
    
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
