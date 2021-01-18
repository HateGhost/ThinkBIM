ThinkBIM 1.0
===============

> 运行环境要求PHP7.1+。
> Swoole 4.x+。


## 主要新特性

* 采用`PHP7`强类型（严格模式）
* 支持更多的`PSR`规范
* 原生多应用支持
* 更强大和易用的查询
* 全新的事件系统
* 模型事件和数据库事件统一纳入事件系统
* 模板引擎分离出核心
* 内部功能中间件化
* SESSION/Cookie机制改进
* 对Swoole以及协程支持改进
* 对IDE更加友好
* 统一和精简大量用法

## Docker安装

> 拉取必要镜像
~~~
docker pull redis
docker pull mysql
docker pull nginx
docker pull memcached:latest
docker pull php:7.4.14-fpm
~~~

>运行镜像 memcached redis mysql php nginx

~~~

docker run --name memcached -p 11211:11211 -itd memcached:latest

docker run --name redis -p 6379:6379 \
-v /root/docker/redis/data:/data \
-itd redis:latest \
redis-server --appendonly yes 

docker run --name mysql -p 3306:3306  \
-v /root/docker/mysql/data/:/var/lib/mysql \
-e MYSQL_ROOT_PASSWORD=12345678 \ 
-itd mysql

docker run --name php8.0.1 -p 9000:9000 \
-v /root/docker/nginx/HateGhost:/usr/share/nginx/HateGhost \
-v /root/docker/nginx/ThinkBIM:/usr/share/nginx/ThinkBIM \
-itd php:8.0.1-fpm

docker run --name nginx -p 80:80 -p 443:443 \
-v /root/docker/nginx/cert/:/etc/nginx/cert/ \
-v /root/docker/nginx/conf/conf.d/thinkbim.conf:/etc/nginx/conf.d/thinkbim.conf \
-v /root/docker/nginx/conf/conf.d/hateghost.conf:/etc/nginx/conf.d/hateghost.conf \
-v /root/docker/nginx/ThinkBIM:/usr/share/nginx/ThinkBIM \
-v /root/docker/nginx/HateGhost:/usr/share/nginx/HateGhost \
 -itd nginx
~~~

## 安装PHP扩展

>进入PHP容器
~~~
docker exec -it php7.4.14 /bin/bash
~~~

> 安装依赖

~~~
apt-get update
apt-get install -y --no-install-recommends libmemcached-dev zlib1g-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev
apt-get install zip unzi git
~~~

> redis下载安装

~~~
curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/5.3.2.tar.gz
tar -zxf redis.tar.gz
~~~

> 创建   /usr/src/php/ext 目录
~~~
docker-php-source extracth
~~~

> 使用docker-php-ext-install安装扩展
~~~
mv phpredis-5.3.2/ /usr/src/php/ext/
docker-php-ext-install phredis-5.3.2
~~~

> memcached下载安装

~~~
curl -L -o /tmp/memcached.tar.gz https://github.com/php-memcached-dev/php-memcached/archive/v3.1.5.tar.gz
tar -zxf ...
mv ..  /usr/src/php/ext
docker-php-ext-install php-memcached-5.3.2
~~~


> pecl 安装扩展

~~~
pecl install swoole
docker-php-ext-enable swoole
~~~

> 常用扩展

~~~
docker-php-ext-install gd pdo_mysql mysqli
~~~

> 检查安装

~~~
php -m
~~~


>安装composer

~~~
curl -sS https://getcomposer.org/installer | php
mv ./composer.phar /usr/local/bin/composer
~~~

~~~
git clone https://github.com/ThinkBIM/ThinkBIM.git
composer install
~~~

## 登录
* [前端示例](https://www.thinkbim.cn)
* [接口成功示例](https://www.thinkbim.cn/v1/info/success)
* [接口失败示例](https://www.thinkbim.cn/v1/info/error)
* [后端入口](https://www.thinkbim.cn/admin)


## 感谢

[ThinkPHP v6.x](https://www.kancloud.cn/manual/thinkphp6_0/content)
[ThinkAdmin](https://thinkadmin.top/README)
[CatchAdmin](https://www.catchadmin.com/docs/)

