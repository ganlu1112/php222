<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Transformers\UserTransformer;
use Dingo\Api\Http\Request;

class UseController extends BaseController
{
    /**
     * 用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');

        $users = User::when($name,function ($query) use ($name){
            $query->where('name','like',"%$name%");
        })->when($email,function ($query) use ($email) {
            $query->where('email', $email);
        })->paginate(2);
        return $this->response->paginator($users,New UserTransformer());
    }



    /**
     * 用户详情
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->response->item($user,New UserTransformer());
    }

    /**
     * 禁用用户
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lock(User $user)
    {
        $user->is_locked = $user->is_locked==0 ? 1:0;
        $user->save();
        return $this->response->noContent();
    }

}
