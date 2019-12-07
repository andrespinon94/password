<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\User;

class CategoryController extends Controller
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
        $category = new Category();

        $email = $request->data_token->email;
        $user = User::where('email', $email)->first();
   
        $name = $request->name;
        $id_user = $user->id;
        
        $category_repeated = Category::where('id_user', $id_user)->where('name',$name)->first();

         if (isset($category_repeated)) 
            {
                return response()->json([
                    "message" => "Categoria ya esta creada"
                ], 200);
            }

        $category->createCategory($name, $user);

        return response()->json([
            "message" => "Categoria Creada"
        ], 200);

    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = User::where('email',$request->data_token->email)->first();
        $categories = Category::where('id_user',$user->id)->get();

       if (isset($categories)) {    
            return response()->json([ "Categories" => $categories]);
        }else{
            return response()->json(["Error" => "No existen categorias que mostrar"]);
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

        $category->name = $request->category_new_name;
        $category->update();

        return response()->json(["Success" => "catgory edited"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         //destry da problemas al usar _method delete. averiguar  porqua
         
    }
}
