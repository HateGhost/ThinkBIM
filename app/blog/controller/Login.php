<?php
declare (strict_types = 1);

namespace app\blog\controller;


use think\facade\Session;

class Login
{
    public function index()
    {
        $response_type = 'code';
        $redirect_uri = urlencode('https://www.thinkbim.cn/blog/callback?third=qq');
        $client_id = '101931916';
        $state = '++--++';
        $url = "https://graph.qq.com/oauth2.0/authorize?response_type=$response_type&client_id=$client_id&redirect_uri=$redirect_uri&state=$state";
        return redirect($url);
    }


    public function out()
    {
        Session::clear();
        return redirect('/blog');
    }
}
