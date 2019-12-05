<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    protected $table = 'passwords';
    protected $fillable = ['id','id_category','title','password'];

    public function givePassword($password_content,$title,$category)
    {
        $password = new Password();

        $password->title = $title;
        $password->password = $password_content;
        $password->id_category = $category->id;
        //$password->checkPassword($password);
        $password->save();
    }

   /* public function checkPassword($password)
    {
        $password_repeated = Password::where('id_category', $password->id_category)->where('title',$password->title)->first();

         if (isset($password_repeated)) 
            {
                return response()->json([
                    "message" => "contrasena ya esta creada"
                ], 200);
            }
    }
    */
}
