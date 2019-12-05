<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['id','email','name','password'];


    public function _construct() 
    {
 
    }
    public function register($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
    }

    public function categories()
    {
        return $this->hasMany('App\user', 'user_id');
    }

}
