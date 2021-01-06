<?php
declare (strict_types = 1);

namespace app\blog\controller;

use think\facade\View;

class Link
{
    public function index()
    {
        View::assign('title', 'ThinkBIM - 链接');
        $list = [
            ['url' => 'http://web.thinkbim.io','name'=>'ThinkBIM','logo'=>'http://web.thinkbim.io/static/logo.png']
        ];
        View::assign('list', $list);
        return View::fetch();
    }
}
