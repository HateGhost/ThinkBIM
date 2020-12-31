<?php
declare (strict_types = 1);

namespace app\v1\controller;

use ThinkBIM\AuthService;
use ThinkBIM\Response;
use thans\jwt\facade\JWTAuth;

class Login
{
    public function index()
    {
        $param = request()->param();

        $auth = new AuthService();
        $res = $auth->jwt();
        print_r($res);
        die;

        return Response::success();
    }

    public function logout()
    {
        return Response::success('', '退出');
    }

    public function refreshToken()
    {
        // ini_set('memory_limit', '2G');
        try{
            JWTAuth::refresh();
        }catch (\Exception $e) {
            print_r($e);die;
        }

        return Response::success(['token' => JWTAuth::refresh()]);
    }
}
