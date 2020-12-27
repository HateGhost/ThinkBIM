<?php

namespace app\admin\controller;

use ThinkBIM\AdminController;
use think\facade\View;

/**
 * 应用参数配置
 * Class Config
 * @package app\admin\controller
 */
class Data extends AdminController
{
    /**
     * 微信小程序配置
     * @auth true
     * @menu true
     */
    public function wxapp()
    {
        $this->title = '微信小程序配置';
        $this->__sysconf('wxapp');
    }

    /**
     * 短信接口配置
     * @auth true
     * @menu true
     */
    public function message()
    {
        if ($this->request->isGet()) {
            $this->title = '短信接口配置';
            $this->result = MessageService::instance()->balance();
        }
        $this->__sysconf('message');
    }

    /**
     * 关于我们描述
     * @auth true
     * @menu true
     */
    public function about()
    {
        View::assign('title', '关于我们描述');
        View::assign('skey', 'about');

        if ($this->request->isGet()) {
            View::assign('data', sysdata('about'));
            return View::fetch('content');
        } elseif ($this->request->isPost()) {
            if (is_string(input('data'))) {
                $data = json_decode(input('data'), true) ?: [];
            } else {
                $data = request()->post();
            }
            if (sysdata('about', $data) !== false) {
                $this->success('内容保存成功！', '');
            } else {
                $this->error('内容保存失败，请稍候再试!');
            }
        }
    }

    /**
     * 应用轮播图片
     * @menu true
     * @auth true
     */
    public function slider()
    {

        View::assign('title', '应用轮播图片');
        View::assign('skey', 'slider');

        if ($this->request->isGet()) {
            View::assign('data', sysdata('slider'));
            return View::fetch('content');
        } elseif ($this->request->isPost()) {
            if (is_string(input('data'))) {
                $data = json_decode(input('data'), true) ?: [];
            } else {
                $data = request()->post();
            }
            if (sysdata('slider', $data) !== false) {
                $this->success('内容保存成功！', '');
            } else {
                $this->error('内容保存失败，请稍候再试!');
            }
        }

    }

    /**
     * 用户服务协议
     * @auth true
     * @menu true
     */
    public function agreement()
    {
        View::assign('title', '用户服务协议');
        View::assign('skey', 'agreement');

        if ($this->request->isGet()) {
            View::assign('data', sysdata('agreement'));
            return View::fetch('content');
        } elseif ($this->request->isPost()) {
            if (is_string(input('data'))) {
                $data = json_decode(input('data'), true) ?: [];
            } else {
                $data = request()->post();
            }
            if (sysdata('agreement', $data) !== false) {
                $this->success('内容保存成功！', '');
            } else {
                $this->error('内容保存失败，请稍候再试!');
            }
        }
    }


    /**
     * 显示并保存配置
     * @param string $template 模板文件名称
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function __sysconf(string $template)
    {
        if ($this->request->isGet()) {
            $this->fetch($template);
        } elseif ($this->request->isPost()) {
            $data = $this->request->post();
            foreach ($data as $k => $v) sysconf($k, $v);
            $this->success('配置保存成功！');
        }
    }
}
