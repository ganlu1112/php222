<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*$string = 'id,pid,name,level';
        $categories = Category::select('id','pid','name','level')->with(
            'children:'.$string,
            'children.children:'.$string)->get();*/
        $type = $request->input('type');
        //type=1只获取有效分类
        if ($type){
            return categoryCache();
        } else {
            return categoryCacheAll();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insertData = $this->checkInput($request);
        if (!is_array($insertData)) return $insertData;
        Category::create($insertData);

        return $this->response->created();
     }

    /**
     * 获取分类详情
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * 更新分类
     */
    public function update(Request $request)
    {


        $updateData = $this->checkInput($request);
        if (!is_array($updateData)) return $updateData;
        Category::update($updateData);

        return $this->response->created();
    }

    /**
     * 验证输入
     */
    protected function checkInput(Request $request)
    {
        $request->validate([
            'name' => 'required|max:16'],[
                'name.required' => '分类名称不能为空'
            ]
        );

        $pid = $request->input('pid',0);
        $level = $pid == 0 ? 1:(Category::find($pid)->level+1);
        if ($level > 3){
            return $this->response->errorBadRequest('最小分类级别为3');
        }
        return [
            'name' => $request->input('name',0),
            'pid' => $pid,
            'level' => $level,
        ];

    }

    /**
     *状态禁用和启用
     */
    public function status(Category $category)
    {
        $category->status = $category->status == 1 ? 0:1;
        $category->save();
        return $this->response->noContent();
    }
}
