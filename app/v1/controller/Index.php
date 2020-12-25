<?php
declare (strict_types = 1);

namespace app\v1\controller;

use ghost\exceptions\FailedException;
use ghost\GhostResponse;
use think\facade\View;

class Index
{
    public function index()
    {


        throw new FailedException('xxxxxxx');

        return GhostResponse::success();
        // return View::fetch();
        // return '您好！这是一个[v1]示例应用';
    }

    public function cc()
    {
        echo memory_get_usage().PHP_EOL;
        echo 1;die;
    }
}
