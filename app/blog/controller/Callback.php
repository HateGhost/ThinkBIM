<?php
declare (strict_types = 1);

namespace app\blog\controller;


use think\facade\Session;

class Callback
{
    public function index()
    {
        $client_id = '101931916';
        $client_secret = '444eabd5414ceb06eb9cf76babee79bc';
        $code = input('code');
        $redirect_uri = 'https://www.thinkbim.cn/blog/callback?third=qq';
        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
            . "client_id=" . $client_id . "&redirect_uri=" . urlencode($redirect_uri)
            . "&client_secret=" . $client_secret . "&code=" . $code . "&fmt=json";
        $token = file_get_contents($token_url);
        $token = json_decode($token, true);

        if(!isset($token['access_token'])) {
            return redirect('/blog');
        }

        $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=".$token['access_token'].'&fmt=json';
        $openid  = file_get_contents($graph_url);
        $openid = json_decode($openid, true);

        $user_url = 'https://graph.qq.com/user/get_user_info?access_token='.$token['access_token'].'&oauth_consumer_key=101931916&openid='.$openid['openid'];
        $userinfo = file_get_contents($user_url);
        $userinfo = json_decode($userinfo, true);
        Session::set('thinkbim_blog_user', $userinfo);
        return redirect('/blog');
    }


}
