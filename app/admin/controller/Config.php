<?php
declare (strict_types = 1);

namespace app\admin\controller;

use app\Request;
use ghost\AdminController;
use ghost\AdminService;
use ghost\SystemService;
use think\facade\View;

class Config extends AdminController
{
    public function index(Request $request)
    {

        View::assign('title', '系统登录');
        View::assign('app', ['isDebug' => false]);

        View::assign('isSuper', AdminService::instance()->isSuper());
        // View::assign('version', ModuleService::instance()->getVersion());
        // View::assign('captchaType','LoginCaptcha');
        // View::assign('captchaToken', Random::uniqidDate());
        // $this->devmode = SystemService::instance()->checkRunMode('dev');
        // if (!$this->app->session->get('login_input_session_error')) {
        //     $this->app->session->set($this->captchaType, $this->captchaToken);
        // }
        return View::fetch();
    }

    public function system()
    {
        if ($this->request->isGet()) {
            View::assign('title', '修改系统参数');
            return View::fetch();
        } else {
            if ($xpath = $this->request->post('xpath')) {
                if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $xpath)) {
                    $this->error('后台入口名称需要是由英文字母开头！');
                }
                if ($xpath !== 'admin' && file_exists($this->app->getBasePath() . $xpath)) {
                    $this->error("后台入口名称{$xpath}已经存在应用！");
                }
                SystemService::instance()->setRuntime(null, [$xpath => 'admin']);
            }
            foreach ($this->request->post() as $name => $value) sysconf($name, $value);
            $this->success('修改系统参数成功！', sysuri("{$xpath}/index/index") . '#' . url("{$xpath}/config/index"));
        }
    }
}
