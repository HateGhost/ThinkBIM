<?php
declare (strict_types = 1);

namespace app\v1\controller;

use ThinkBIM\exceptions\FailedException;
use ThinkBIM\Response;

class Index
{
    public function index()
    {
        if(1==1) {
            throw new FailedException('xxxxxxx');
        }


        return Response::fail('xxxxxxxxxxxxxxxxxxxxxxxx');
    }

    public function success()
    {
        // echo memory_get_usage().PHP_EOL;
        return Response::success(['nickname' => 'ThinkBIM'], '请求成功');
    }

    public function error()
    {
        return Response::fail('这是个错误消息');
    }
}
