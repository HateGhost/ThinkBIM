<?php
declare (strict_types = 1);

namespace app\blog\controller;

use think\facade\View;

class Message
{
    public function index()
    {
        View::assign('title', 'ThinkBIM - 留言');
        View::assign('list', [1]);
        return View::fetch();
    }
}
