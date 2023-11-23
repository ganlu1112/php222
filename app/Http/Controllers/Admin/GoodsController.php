<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\GoodsRequest;
use App\Models\Category;
use App\Models\Good;
use App\Transformers\GoodTransformer;
use Dingo\Api\Auth\Auth;
use Illuminate\Http\Request;

class GoodsController extends BaseController
{
    /**
     * 商品列表
     */
    public function index(Request $request)
    {
        $g_name = $request->query('g_name');
        $c_id = $request->query('$c_id');
        $is_on = $request->query('is_on',false);
        $is_recommend = $request->query('is_recommend',false);

        $goods = Good::when($g_name,function ($query) use ($g_name){
            $query->where('g_name','like',"%$g_name%");
        })->when($c_id,function ($query) use ($c_id){
            $query->where('c_id',$c_id);
        })->when($is_on !== false,function ($query) use ($is_on){
            $query->where('is_on',$is_on);
        })->when($is_recommend !== false,function ($query) use ($is_recommend){
            $query->where('is_recommend',$is_recommend);
        })
            ->paginate(2);

        return $this->response->paginator($goods,new GoodTransformer());
    }

    /**
     * 添加商品
     */
    public function store(GoodsRequest $request)
    {
        $category = Category::find($request->c_id);
        if (!$category) return $this->response->errorBadRequest('分类不存在');
        if ($category->status == 0) return $this->response->errorBadRequest('分类已禁用');
        if ($category->level < 3) return $this->response->errorBadRequest('只能在3级分类里添加商品');

        $user_id = auth('api')->id();

        //追加字段
        $request->offsetSet('user_id',$user_id);
//        $request->user_id = $user_id; //不能这么用
        Good::create($request->all());
        return $this->response->created();
    }

    /**
     * 商品详情
     */
    public function show(Good $good)
    {
        return $this->response->item($good,new GoodTransformer());
    }

    /**
     * 更新商品
     */
    public function update(GoodsRequest $request, Good $goods)
    {
        $category = Category::find($request->c_id);
        if (!$category) return $this->response->errorBadRequest('分类不存在');
        if ($category->status == 0) return $this->response->errorBadRequest('分类已禁用');
        if ($category->level < 3) return $this->response->errorBadRequest('只能在3级分类里添加商品');

        $goods->update($request->all());
        return $this->response->noContent();
    }

    /**
     * 是否上架
     */
    public function isOn(Good $good)
    {
        $good->is_on = $good->is_on == 1 ? 0:1;
        $good->save();
        return $this->response->noContent();
    }

    /**
     * 是否推荐
     */
    public function isRecommend(Good $good)
    {
        $good->is_recommend = $good->is_recommend == 1 ? 0:1;
        $good->save();
        return $this->response->noContent();
    }
}
