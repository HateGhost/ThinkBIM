<?php
declare (strict_types = 1);

namespace app\admin\controller;

use ghost\AdminService;
use ghost\MenuService;
use think\facade\View;

class Index
{
    public function index()
    {
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


            return View::fetch('user/form');


            // $this->_form('SystemUser', 'admin@user/form', 'id', [], ['id' => $id]);
        } else {
            // $this->error('只能修改自己的资料！');
        }
    }

    public function pass($id)
    {
        View::assign('verify', true);
        return View::fetch('user/pass');
    }
}
