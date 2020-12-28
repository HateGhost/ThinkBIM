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

    public function cc()
    {
        // echo memory_get_usage().PHP_EOL;
        return Response::success('xxxxx');
    }
}
