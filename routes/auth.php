<?php
//api路由实例
$api = app('Dingo\Api\Routing\Router');


$api->version('v1',['middleware' => 'api.throttle','limit'=> 60, 'expires'=> 5] ,function ($api) {

    $api->group(['prefix' => 'auth'], function($api){
        //注册
        $api->post('register', [\App\Http\Controllers\Auth\RegisterController::class,'store']);
        //登录
        $api->post('login', [\App\Http\Controllers\Auth\LoginController::class,'login']);

        //需要登录的路由
        $api->group(['middleware' => 'api.auth'], function($api){
            //退出登录
            $api->post('logout', [\App\Http\Controllers\Auth\LoginController::class,'logout']);
            //刷新token
            $api->post('refresh', [\App\Http\Controllers\Auth\LoginController::class,'refresh']);
            //阿里云OSS token
            $api->get('oss/token', [\App\Http\Controllers\Auth\OssController::class,'token']);
        });
    });

});


