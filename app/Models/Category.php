<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //批量赋值
    protected $fillable = ['name','pid','level'];

    //分类的子类
    public function children(){
        return $this->hasMany(Category::class,'pid','id');
    }
}
