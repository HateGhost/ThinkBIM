<?php
declare (strict_types = 1);

namespace app\v1\controller;

use ThinkBIM\GhostAuth;
use ThinkBIM\GhostResponse;
use thans\jwt\facade\JWTAuth;

class Login
{
    public function index()
    {
        $param = request()->param();

        $auth = new GhostAuth();
        $res = $auth->jwt();
        print_r($res);
        die;

        return GhostResponse::success();
    }

    public function logout()
    {

        return GhostResponse::success('', '退出');
    }

    public function refreshToken()
    {
        // ini_set('memory_limit', '2G');
        try{
            JWTAuth::refresh();
        }catch (\Exception $e) {
            print_r($e);die;
        }

        return GhostResponse::success(['token' => JWTAuth::refresh()]);
    }
}
