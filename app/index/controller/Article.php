<?php
declare (strict_types = 1);

namespace app\index\controller;

use think\facade\View;

class Article
{
    public function index()
    {
        return View::fetch();
    }

    public function read()
    {
        return View::fetch();
    }

    public function diary()
    {
        return View::fetch();
    }
}
