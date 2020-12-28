<?php


namespace ThinkBIM;


class FormTokenService extends Service
{

    public function buildToken($node = null)
    {
        // $cnode = NodeService::instance()->fullnode($node);
        // [$token, $time] = [uniqid() . rand(100000, 999999), time()];
        // $this->app->cache->set($token, ['node' => $cnode, 'time' => $time]);
        // return $token ?: '';
        return '';
    }

    public function checkToken()
    {
        return true;
    }


}
