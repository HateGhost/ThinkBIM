<?php


namespace ThinkBIM;


use thans\jwt\facade\JWTAuth;

class AuthService extends Service
{

    public function jwt()
    {
        $token = JWTAuth::builder(['uid' => 1]);
        JWTAuth::setToken($token);
        return $token;
    }

    public function user()
    {
        return true;
    }

    public function isSuperUser()
    {
        return true;
    }
}
