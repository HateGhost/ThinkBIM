<?php
declare (strict_types = 1);

namespace app\blog\controller;

use think\facade\View;

class Link
{
    public function index()
    {
        View::assign('title', 'ThinkBIM - 链接');
        return View::fetch();
    }
}
