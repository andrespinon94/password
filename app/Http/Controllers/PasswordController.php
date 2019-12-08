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

        $category = Category::where('id_user', $id_user)->where('name', $category_name)->first();

        if (!isset($category)) 
        {
            return response()->json(["message" => "Categoria no esta creada"], 200);
        }

        $password_repeated = Password::where('id_category', $category->id)->where('title', $title)->first();

        if (isset($password_repeated)) 
        {
            return response()->json(["message" => " esta contrasena ya esta creada"], 200);
        }
       
        $password->givePassword($password_content, $title, $category);

        return response()->json(["message" => "Contrasena Creada"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request)
    {
        $array_passwords = array();
        $user = User::where('email', $request->data_token->email)->first();
        $categories = Category::where('id_user', $user->id)->get();

        if (isset($categories)) 
        {
            foreach ($categories as $key => $category) {

                $passwords = Password::where('id_category',$category->id)->get();
                array_push($array_passwords, $passwords);
            }
//probar esta linea
            if (!isset($array_passwords)) {
                return response()->json([ "passwords" => " No passwords to show on this categories"]);
            }
        
            return response()->json([ "passwords" => $array_passwords]);

        } else {
            return response()->json(["Error" => "No existen categorias  con contraseñas que mostrar"]);
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
    public function update(Request $request)
    {
        $user = User::where('email',$request->data_token->email)->first();

        $category = Category::where('id_user',$user->id)->where('name',$request->category_name)->first();

        if (isset($category)) 
        {
        return response()->json([ "message" => "la categoria no existe"], 200);
        }

        $password = Password::where('id_category',$category->id)->where('title',$request->title)->first();
        
        if (isset($password)) 
        {
        return response()->json([ "message" => "password does not exist"], 200);
        }

        $password->title = $request->new_title;
        $password->password =$request->new_password;
        $password->update();

        return response()->json(["Success" => "password edited"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user= User::where('email',$request->data_token->email)->first();
        $category = Category::where('name', $request->category_name)->where('id_user',$user->id)->first();
        $password = Password::where('title', $request->title)->where('id_category',$category->id)->first();

        if (isset($password)) 
        {
            $password->delete();
            return response()->json([
                "success" => 'contraseña eliminada'
            ], 201);
        }else{
            return response()->json([
                "error" => 'la contraseña a eliminar no existe'
            ], 401);
        }
    }
}
