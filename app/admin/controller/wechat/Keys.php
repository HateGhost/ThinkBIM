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

namespace app\admin\controller\wechat;

use app\admin\service\WechatService;
use think\exception\HttpResponseException;
use think\facade\Db;
use think\facade\View;
use ThinkBIM\AdminController;

/**
 * 回复规则管理
 * Class Keys
 * @package app\wechat\controller
 */
class Keys extends AdminController
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'WechatKeys';

    /**
     * 消息类型
     * @var array
     */
    public $types = [
        'text'  => '文字', 'news' => '图文', 'image' => '图片', 'music' => '音乐',
        'video' => '视频', 'voice' => '语音', 'customservice' => '转客服',
    ];

    /**
     * 回复规则管理
     * @auth true
     * @menu true
     */
    public function index()
    {
        // 关键字二维码生成
        // if ($this->request->get('action') === 'qrc') try {
        //     $wechat = WechatService::WeChatQrcode();
        //     $result = $wechat->create($this->request->get('keys', ''));
        //     $this->success('生成二维码成功！', "javascript:$.previewImage('{$wechat->url($result['ticket'])}')");
        // } catch (HttpResponseException $exception) {
        //     throw $exception;
        // } catch (\Exception $exception) {
        //     $this->error("生成二维码失败，请稍候再试！<br> {$exception->getMessage()}");
        // }
        // 数据列表分页处理
        // $this->title = '回复规则管理';
        $list = Db::name($this->table)->page(1)->select();
            // ->whereNotIn('keys', ['subscribe', 'default']);
        // $query->equal('status')->like('keys,type');
        // $list = $query->whereBetweenTime('create_at', '', '')->order('sort desc,id desc')->page(1);
        // var_dump($query->getLastSql());die;
        View::assign('title', '回复规则管理');
        View::assign('list', $list);
        View::assign('types', []);
        return View::fetch();
    }

    /**
     * 列表数据处理
     * @param array $data
     */
    protected function _index_page_filter(array &$data)
    {
        foreach ($data as &$vo) {
            $vo['type'] = $this->types[$vo['type']] ?? $vo['type'];
            $vo['qrc'] = sysuri('wechat/keys/index') . "?action=qrc&keys={$vo['keys']}";
        }
    }

    /**
     * 添加回复规则
     * @auth true
     */
    public function add()
    {
        View::assign('title', '添加回复规则');
        View::assign('types', $this->types);
        View::assign('defaultImage', '');
        return View::fetch('form');
    }

    /**
     * 编辑回复规则
     * @auth true
     */
    public function edit()
    {
        $this->_applyFormToken();
        $this->title = '编辑回复规则';
        $this->_form($this->table, 'form');
    }

    /**
     * 修改回复规则状态
     * @auth true
     */
    public function state()
    {
        $this->_applyFormToken();
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

    /**
     * 删除回复规则
     * @auth true
     */
    public function remove()
    {
        $this->_applyFormToken();
        $this->_delete($this->table);
    }

    /**
     * 配置关注回复
     * @auth true
     * @menu true
     */
    public function subscribe()
    {
        // $this->_applyFormToken();
        if($this->request->post()) {

            $this->app->db->name($this->table)->insert($this->request->post());
            $this->success('内容保存成功', '');
        }
        View::assign('title', '编辑关注回复规则');
        View::assign('types', $this->types);
        View::assign('keys', 'subscribe');
        View::assign('defaultImage', '');
        return View::fetch('form');
    }

    /**
     * 配置默认回复
     * @auth true
     * @menu true
     */
    public function defaults()
    {
        View::assign('title', '编辑默认回复规则');
        View::assign('keys', 'default');
        View::assign('defaultImage', '');
        View::assign('types', $this->types);
        return View::fetch('form');
        // $this->_applyFormToken();
        // $this->title = '编辑默认回复规则';
        // $this->_form($this->table, 'form', 'keys', [], ['keys' => 'default']);
    }

    /**
     * 添加数据处理
     * @param array $data
     */
    protected function _form_filter(array &$data)
    {
        if ($this->request->isPost()) {
            $map = [['keys', '=', $data['keys']], ['id', '<>', $data['id'] ?? 0]];
            if ($this->app->db->name($this->table)->where($map)->count() > 0) {
                $this->error('该关键字已经存在！');
            }
        } elseif ($this->request->isGet()) {
            $public = dirname($this->request->basefile(true));
            $this->defaultImage = "{$public}/static/theme/img/image.png";
        }
    }

    /**
     * 表单结果处理
     * @param boolean $result
     */
    protected function _form_result(bool $result)
    {
        if ($result !== false) {
            $iskeys = in_array(input('keys'), ['subscribe', 'default']);
            $location = $iskeys ? 'javascript:$.form.reload()' : 'javascript:history.back()';
            $this->success('恭喜, 关键字保存成功！', $location);
        } else {
            $this->error('关键字保存失败, 请稍候再试！');
        }
    }

}
