<?php


use App\Models\Category;

//分类结果树
if (!function_exists('categoryTree')){
    function categoryTree($status = false){
        $categories = Category::select(['id','pid','name','level','status'])
            ->when($status != false,function ($query) use ($status) {
                $query->where('status',$status);
            })
            ->where('pid',0)
            ->with([
            'children' => function ($query) use ($status){
                $query->select(['id','pid','name','level','status'])
                    ->when($status != false,function ($query) use ($status){
                        $query->where('status',$status);
                    });
            },
            'children.children' => function ($query) use ($status){
                $query->select(['id','pid','name','level','status'])
                    ->when($status != false,function ($query) use ($status){
                        $query->where('status',$status);
                    });
            },
            ])->get();
        return $categories;
    }
}

//缓存所有分类
if (!function_exists('categoryCacheAll')){
    function categoryCacheAll(){
        return cache()->rememberForever('categoryCacheAll',function (){
            return categoryTree();
        });
    }
}

//缓存没禁用的分类
if (!function_exists('categoryCache')){
    function categoryCache(){

        return cache()->rememberForever('categoryCache',function (){
            return categoryTree(1);
        });
    }
}

//清空分类缓存
if (!function_exists('forget_categoryCache')){
    function forget_categoryCache(){

        cache()->forget('categoryCache');
        cache()->forget('categoryCacheAll');
    }
}

//存储OSS_URL
if (!function_exists('oss_url')){
    function oss_url($key)
    {
        return config('filesystems')['disks']['oss']['bucket_url'] . '/' . $key;
    }
}
