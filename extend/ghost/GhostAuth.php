<?php


namespace ghost;


use thans\jwt\facade\JWTAuth;

class GhostAuth
{

    public function jwt()
    {
        $token = JWTAuth::builder(['uid' => 1]);
        JWTAuth::setToken($token);
        return $token;
    }
}
