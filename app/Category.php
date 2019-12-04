<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'cateries';
    protected $fillable = ['id','id_user','name'];
}
