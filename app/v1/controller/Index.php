<?php
declare (strict_types = 1);

namespace app\v1\controller;

use think\facade\View;

class Index
{
    public function index()
    {
        return View::fetch();
        // return '您好！这是一个[v1]示例应用';
    }
}
