<?php

namespace app\v1\middleware;

use app\Request;
use app\v1\model\Permissions;
use think\helper\Str;
use think\Middleware;
use ThinkBIM\AuthService;
use ThinkBIM\CacheKeys;
use ThinkBIM\Code;
use ThinkBIM\exceptions\PermissionForbiddenException;

// use catchAdmin\permissions\model\Permissions;
// use catcher\CatchCacheKeys;
// use catcher\Code;
// use catcher\exceptions\PermissionForbiddenException;
// use think\facade\Cache;
// use catcher\Utils;

class PermissionsMiddleware extends Middleware
{
    /**
     * @time 2019年12月12日
     *
     * @param Request  $request
     * @param \Closure $next
     *
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws PermissionForbiddenException
     */
    public function handle(Request $request, \Closure $next)
    {
        $module = app('http')->getName();
        $rule   = $request->rule()->getName();

        if (!$rule) {
            return $next($request);
        }

        // 模块忽略
        [$controller, $action] = $this->parseRule($rule);


        if (in_array($module, $this->ignoreController())) {
            return $next($request);
        }
        // 用户未登录
        $user = AuthService::instance()->user();
        if (!$user) {
            throw new PermissionForbiddenException('Login is invalid', Code::LOST_LOGIN);
        }
        // 超级管理员
        if (AuthService::instance()->isSuperUser()) {
            return $next($request);
        }
        // Get 请求
        if ($this->allowGet($request)) {
            return $next($request);
        }
        // 判断权限
        $permission = property_exists($request, 'permission') ? $request->permission : $this->getPermission($module,
            $controller, $action);

        if (!$permission || !in_array($permission->id, $this->app->cache->get(CacheKeys::USER_PERMISSIONS.$user->id))) {
            throw new PermissionForbiddenException();
        }

        return $next($request);
    }

    /**
     * @time 2019年12月14日
     *
     * @param $module
     * @param $controllerName
     * @param $action
     * @param $request
     *
     * @return array|bool|\think\Model|null
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     */
    protected function getPermission($module, $controllerName, $action)
    {
        $permissionMark = sprintf('%s@%s', $controllerName, $action);

        return $this->app->db->name('Permissions')->where('module', $module)->where('permission_mark', $permissionMark)->find();
    }

    /**
     * 忽略模块
     * @time 2020年04月16日
     * @return array
     */
    protected function ignoreModule()
    {
        return ['login'];
    }

    protected function ignoreController()
    {
        return ['ligin'];
    }

    /**
     * 操作日志
     * @time 2020年04月16日
     *
     * @param $creatorId
     * @param $permission
     *
     * @return void
     */
    protected function operateEvent($creatorId, $permission)
    {
        // 操作日志
        $permission && event('operateLog', [
            'creator_id' => $creatorId,
            'permission' => $permission,
        ]);
    }

    /**
     * get allow
     * @time 2020年10月12日
     *
     * @param $request
     *
     * @return bool
     * @throws \ReflectionException
     */
    protected function allowGet($request)
    {
        if (Utils::isMethodNeedAuth($request->rule()->getName())) {
            return false;
        }

        return $request->isGet() && config('catch.permissions.is_allow_get');
    }

    public function parseRule($rule)
    {
        [$controller, $action] = explode(Str::contains($rule, '@') ? '@' : '/', $rule);

        $controller = explode('\\', $controller);

        $controllerName = lcfirst(array_pop($controller));

        array_pop($controller);

        // $module = array_pop($controller);

        return [$controllerName, $action];
    }
}
