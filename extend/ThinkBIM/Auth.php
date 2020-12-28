<?php


namespace ThinkBIM;


use thans\jwt\facade\JWTAuth;

class Auth
{

    public function jwt()
    {
        $token = JWTAuth::builder(['uid' => 1]);
        JWTAuth::setToken($token);
        return $token;
    }
}
