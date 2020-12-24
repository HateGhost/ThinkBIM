<?php
declare (strict_types = 1);

namespace app\v1\controller;

use ghost\GhostAuth;
use ghost\GhostResponse;

class Login
{
    public function index(GhostAuth $auth)
    {
        $param = request()->param();

        $res = $auth->jwt();
        print_r($res);
        die;

        return GhostResponse::success();
    }

    public function logout()
    {
        echo 1;die;
    }

    public function refreshToken()
    {
        echo 1;die;
    }
}
