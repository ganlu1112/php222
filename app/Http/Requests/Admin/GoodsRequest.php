<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class GoodsRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'g_name' =>'required|max:255',
            'c_id' =>'required',
            'user_id' =>'required',
            'desc' =>'required|max:255',
            'price' =>'required|min:0',
            'cover' =>'required',
            'pics' =>'required|array',
            'stock' =>'required|min:0',
            'detail' =>'required'
        ];
    }
}
