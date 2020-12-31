<?php
declare (strict_types = 1);

namespace app\index\controller;

use think\facade\View;

class Link
{
    public function index()
    {
        return View::fetch('index/link');
    }
}
