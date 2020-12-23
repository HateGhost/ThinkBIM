<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\Request;
use ghost\AdminController;
use ghost\CaptchaService;
use ghost\library\Random;
use think\facade\View;

class Login extends AdminController
{
    public function index(Request $request)
    {
        if($request->isAjax()) {
            $this->success('登录成功', '/admin');
        }
        View::assign('title','系统登录');
        View::assign('captchaType','LoginCaptcha');
        View::assign('captchaToken', Random::uniqidDate());
        // $this->devmode = SystemService::instance()->checkRunMode('dev');
        // if (!$this->app->session->get('login_input_session_error')) {
        //     $this->app->session->set($this->captchaType, $this->captchaToken);
        // }
        return View::fetch();
    }

    public function captcha()
    {
        $image = CaptchaService::instance()->initialize();
        $captcha = ['image' => $image->getData(), 'uniqid' => $image->getUniqid()];

        $this->success('生成验证码成功', $captcha);
    }
}
