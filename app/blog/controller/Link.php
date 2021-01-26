<?php
declare (strict_types=1);

namespace app\blog\controller;

use think\facade\View;

class Link
{
    public function index()
    {
        View::assign('title', 'ThinkBIM - 链接');
        $list = [
            [
                'url'  => 'http://www.thinkbim.cn',
                'name' => 'ThinkBIM',
                'dec' => '个人技术栈',
                'logo' => 'http://www.thinkbim.cn/static/logo.png',
            ],
            [
                'url'  => 'http://www.hateghost.com',
                'name' => 'HateGhost',
                'dec' => '个人主页，联系QQ517966909',
                'logo' => 'http://www.hateghost.com/public/static/logo.png',
            ],
        ];
        View::assign('list', $list);

        return View::fetch();
    }
}
