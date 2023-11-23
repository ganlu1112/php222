<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;

    //批量赋值
    protected $fillable = ['g_name','c_id','user_id','desc','price','cover','pics','stock','detail'];

    protected $casts = [
        'pics' => 'array'
    ];

    //商品表与分类表关联
    public function category(){
        return $this->belongsTo(Category::class,'c_id','id');
    }

    //商品表与分类表关联
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
