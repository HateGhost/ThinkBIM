<?php
// 这是系统自动生成的公共文件

use ghost\SystemService;
use ghost\AdminService;

if (!function_exists('sysconf')) {
    /**
     * 获取或配置系统参数
     * @param string $name 参数名称
     * @param mixed $value 参数内容
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    function sysconf($name = '', $value = null)
    {
        if (is_null($value) && is_string($name)) {
            return SystemService::instance()->get($name);
        } else {
            return SystemService::instance()->set($name, $value);
        }
    }
}

if (!function_exists('sysuri')) {
    /**
     * 生成最短 URL 地址
     * @param string $url 路由地址
     * @param array $vars PATH 变量
     * @param boolean|string $suffix 后缀
     * @param boolean|string $domain 域名
     * @return string
     */
    function sysuri(string $url = '', array $vars = [], $suffix = true, $domain = false)
    {
        return SystemService::instance()->sysuri($url, $vars, $suffix, $domain);
    }
}

if (!function_exists('auth')) {
    /**
     * 访问权限检查
     * @param null|string $node
     * @return boolean
     * @throws ReflectionException
     */
    function auth(?string $node): bool
    {
        return AdminService::instance()->check($node);
    }
}
