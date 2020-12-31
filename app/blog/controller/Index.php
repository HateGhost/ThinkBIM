<?php
declare (strict_types = 1);

namespace app\blog\controller;

use think\facade\View;

class Index
{
    public function index()
    {
        View::assign('title', 'ThinkBIM');
        return View::fetch();
    }

    public function read()
    {
        View::assign('title', 'ThinkBIM');
        return View::fetch();
    }
}
