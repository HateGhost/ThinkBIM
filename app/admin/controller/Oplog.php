<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\facade\View;
use ThinkBIM\AdminController;
use ThinkBIM\AdminService;

/**
 * 系统日志管理
 * Class Oplog
 * @package app\admin\controller
 */
class Oplog extends AdminController
{

    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'SystemOplog';

    /**
     * 系统日志管理
     * @auth true
     * @menu true
     */
    public function index()
    {
        View::assign('title', '系统日志管理');
        View::assign('isSupper', AdminService::instance()->isSuper());
        $query = $this->app->db->name($this->table)->order('id desc');
        // $query->like('action,node,content,username,geoip')->dateBetween('create_at');
        if (input('output') === 'json') {
            $this->success('获取数据成功', $query->page(true, false));
        } else {
            $list = $query->page(1, 20);

        }

        View::assign('list', $list ?? []);
        return View::fetch();
    }

    /**
     * 列表数据处理
     * @auth true
     */
    protected function _index_page_filter(array &$data)
    {
        $ip = new \Ip2Region();
        foreach ($data as &$vo) {
            $isp = $ip->btreeSearch($vo['geoip']);
            $vo['isp'] = str_replace(['内网IP', '0', '|'], '', $isp['region'] ?? '');
        }
    }

    /**
     * 日志行为配置
     * @auth true
     */
    public function config()
    {
        if ($this->request->isPost()) {
            // $data = $this->_vali([
            //     'oplog_state.in:0,1'  => '日志状态值异常！',
            //     'oplog_state.require' => '日志状态不能为空！',
            //     'oplog_days.require'  => '保存天数不能为空!',
            // ]);
            foreach (request()->post() as $name => $value) {
                sysconf($name, $value);
            }
            $GLOBALS['oplogs'] = [];
            $this->success('日志配置成功！');
        }

        return View::fetch();
    }

    /**
     * 清理系统日志
     * @auth true
     */
    public function clear()
    {
        if ($this->app->db->name($this->table)->whereRaw('1=1')->delete() !== false) {
            $this->success('日志清理成功！');
        } else {
            $this->error('日志清理失败，请稍候再试！');
        }
    }

    /**
     * 删除系统日志
     * @auth true
     */
    public function remove()
    {
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

}
