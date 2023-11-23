<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OssController extends Controller
{
    /*
     *生成OSS token
     */
    public function token(){
        $disk = Storage::disk('oss');
        $config = $disk->getAdapter()->signatureConfig($prefix = '/', $callBackUrl = '', $customData = [], $expire = 3600);
        $config = json_decode($config,true);
        return $config;
    }
}
