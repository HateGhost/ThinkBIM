<?php
declare (strict_types = 1);

namespace app\admin\controller;

use think\facade\Request;
use think\middleware\FormTokenCheck;
use ThinkBIM\AdminController;
use ThinkBIM\AdminService;
use ThinkBIM\FormTokenService;
use ThinkBIM\MenuService;
use think\facade\View;

class Index extends AdminController
{
    public function index()
    {

        // print_r(FormTokenService::instance()->buildToken());die;
        //
        // $res = Request::checkToken('__token__');
        // var_dump($res);die;
        if(!AdminService::instance()->isLogin()) {
            return redirect(sysuri('admin/login/index'));
        }

        View::assign('menus', MenuService::instance()->getTree());
        View::assign('title', '系统管理后台');
        return View::fetch();
    }

    public function info($id)
    {
        if (AdminService::instance()->getUserId() === intval($id)) {
            if(request()->isPost()) {
                $this->app->db->name('SystemUser')->update(request()->post());
                $this->success('用户信息修改成功');
            }
            $user = $this->app->db->name('SystemUser')->where('id', $id)->find();
            View::assign('vo', $user);
            return View::fetch('user/form');
        } else {
            $this->error('只能修改自己的资料！');
        }
    }

    public function pass($id)
    {
        $user = $this->app->db->name('SystemUser')->where('id', $id)->find();
        View::assign('vo', $user);
        View::assign('verify', true);
        return View::fetch('user/pass');
    }
}
