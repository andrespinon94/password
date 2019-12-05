<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['id','id_user','name'];

    public function passwords()
    {
        return $this->hasMany('App\category', 'id_category');
    }

    public function createCategory( $name,$user)
    {
        $category = new Category();

        $category->name = $name;
        $category->id_user = $user->id;

        $category->save();
    }

}
