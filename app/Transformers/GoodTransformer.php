<?php

namespace App\Transformers;

use App\Models\Category;
use App\Models\Good;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class GoodTransformer extends  TransformerAbstract
{
    protected $availableIncludes = ['category','user']; //方法二的步骤1

    public function transform(Good $good)
    {
        $picArr = [];
        foreach ($good->pics as $key => $pic){
            $picArr[$key] = oss_url($pic);
        }

        //设置输出的格式
        return [
            'id'            =>$good->id,
            'g_name'        =>$good->g_name,
            'c_id'          =>$good->c_id,
//            'c_name'        =>Category::find($good->id)->name, //方法一：关联表数据
            'desc'          =>$good->desc,
            'price'         =>$good->price,
            'cover'         =>$good->cover,
            'cover_url'     =>oss_url($good->cover),
            'pics'          =>$good->pics,
            'pics_url'      =>$picArr,
            'stock'         =>$good->stock,
            'detail'        =>$good->detail,
            'is_on'         =>$good->is_on,
            'is_recommend'  =>$good->is_recommend,
            'created_at'    =>$good->created_at,
            'updated_at'    =>$good->updated_at
        ];
    }

    //方法二的步骤2
    /*
     * 显示额外的关联分类表数据
     * 注意在表模型中设置关联关系
     * */
    public function includeCategory(Good $goods){
        return $this->item($goods->category,new CategoryTransformer());
    }


    /*
     * 显示额外的关联用户表表数据
     * 注意在表模型中设置关联关系
     * */
    public function includeUser(Good $goods){
        return $this->item($goods->user,new UserTransformer());
    }
}
