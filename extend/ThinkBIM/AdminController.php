<?php


namespace ThinkBIM;


use app\BaseController;
use think\exception\HttpResponseException;
use think\middleware\FormTokenCheck;

class AdminController extends BaseController
{
    public function _form()
    {

    }

    public function error($info, $data = '{-null-}', $code = 0): void
    {
        if ($data === '{-null-}') $data = new \stdClass();
        throw new HttpResponseException(json([
            'code' => $code, 'info' => $info, 'data' => $data,
        ]));
    }

    public function success($info, $data = '{-null-}', $code = 1): void
    {
        // if ($this->csrf_state) {
        //     FormTokenCheck::instance()->clear();
        // }
        if ($data === '{-null-}') $data = new \stdClass();
        throw new HttpResponseException(json([
            'code' => $code, 'info' => $info, 'data' => $data,
        ]));
    }
}
