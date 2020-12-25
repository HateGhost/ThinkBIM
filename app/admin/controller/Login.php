<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\Request;
use ghost\AdminController;
use ghost\AdminService;
use ghost\CaptchaService;
use ghost\library\Random;
use think\facade\View;

class Login extends AdminController
{
    public function index(Request $request)
    {
        if($request->isPost()) {
            $post = $request->post();
            if(!CaptchaService::instance()->check($post['verify'], $post['uniqid'])) {
                $this->error('验证码错误，请重新输入~~');
            }
            $map = [
                'username' => $post['username'],
                'is_deleted' => 0
            ];
            $user = $this->app->db->name('SystemUser')->where($map)->find();
            if(empty($user)) {
                $this->app->session->set("login_input_session_error", true);
                $this->error('登录账号或密码错误，请重新输入!');
            }

            if (md5("{$user['password']}{$post['uniqid']}") !== $post['password']) {
                $this->app->session->set("login_input_session_error", true);
                $this->error('登录账号或密码错误，请重新输入!');
            }
            if (empty($user['status'])) {
                $this->error('账号已经被禁用，请联系管理员!');
            }
            //设置登录信息
            $this->app->session->set('user', $user);
            $this->app->session->delete("login_input_session_error");
            $this->app->db->name('SystemUser')->where(['id' => $user['id']])->update([
                'login_ip'  => $this->app->request->ip(),
                'login_at'  => $this->app->db->raw('now()'),
                'login_num' => $this->app->db->raw('login_num+1'),
            ]);
            $this->success('登录成功', sysuri('admin/index/index'));
        }

        if(AdminService::instance()->isLogin()) {
            return redirect(sysuri('admin/index/index'));
        }
        View::assign('title','系统登录');
        View::assign('captchaType','LoginCaptcha');
        View::assign('captchaToken', Random::uniqidDate());
        return View::fetch();
    }

    public function captcha()
    {
        $image = CaptchaService::instance()->initialize();
        $captcha = ['image' => $image->getData(), 'uniqid' => $image->getUniqid()];

        $this->success('生成验证码成功', $captcha);
    }
}
