<?php
//api路由实例
$api = app('Dingo\Api\Routing\Router');

$params = [
    'middleware' => [
        'api.throttle',
        'serializer:array',//减少transform的包裹层
        'bindings'  //支持路由模型注入
    ],
    'limit'=> 60,
    'expires'=> 5];
$api->version('v1', $params, function ($api) {

    $api->group(['prefix' => 'admin'], function($api){


        //需要登录的路由
        $api->group(['middleware' => 'api.auth'], function($api){

            //禁用用户
            $api->patch('users/{user}/lock', [\App\Http\Controllers\Admin\UseController::class,'lock']);
            //用户管理
            $api->resource('users',\App\Http\Controllers\Admin\UseController::class,[
                'only' => ['index','show']
            ]);

            //分类管理
            $api->resource('category',\App\Http\Controllers\Admin\CategoryController::class,[
                'except' => ['destroy']
            ]);
            //分类禁用启用
            $api->patch('category/{category}/status', [\App\Http\Controllers\Admin\CategoryController::class,'status']);

            //商品管理
            $api->resource('goods',\App\Http\Controllers\Admin\GoodsController::class,[
                'except' => ['destroy']
            ]);
            //是否上架
            $api->patch('goods/{good}/on', [\App\Http\Controllers\Admin\UseController::class,'isOn']);
            //是否推荐
            $api->patch('goods/{good}/recommend',[\App\Http\Controllers\Admin\GoodsController::class,'isRecommend']);
        });
    });

});


