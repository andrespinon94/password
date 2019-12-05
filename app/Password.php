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

        $password->save();
    }
}
