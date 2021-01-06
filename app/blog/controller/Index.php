<?php
declare (strict_types = 1);

namespace app\blog\controller;

use think\facade\View;

class Index
{
    public function index()
    {
        View::assign('title', 'ThinkBIM');
        View::assign('list', [1,2,3]);

        $cate = [
            '全部文章',
            '个人日记',
            'HTML5 CSS3',
            'JavaScript',
            'PHP',
            '其他'
        ];

        $vistor = [
            ['url' => 'https://thirdqq.qlogo.cn/qqapp/101465933/59AA25A7627284AE62C8E6EBDC6FE417/100', 'nickname' => 'test1'],
            ['url' => 'https://thirdqq.qlogo.cn/qqapp/101465933/59AA25A7627284AE62C8E6EBDC6FE417/100', 'nickname' => 'test1']
        ];

        // 分类
        View::assign('cate', $cate);
        // 访客
        View::assign('vistor', $vistor);
        $hotArticle = [];
        // 热门文章
        View::assign('hotArticle', $hotArticle);
        $topArticle = [];
        // 置顶文章
        View::assign('topArticle', $topArticle);
        return View::fetch();
    }

    public function read()
    {
        View::assign('title', 'ThinkBIM');
        return View::fetch();
    }
}
