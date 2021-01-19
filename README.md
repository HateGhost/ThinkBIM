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
docker pull memcached
docker pull php:7.4.14-fpm
~~~

>创建volume
~~~
## redis
mkdir -p /home/redis/data
## mysql
mkdir -p /home/mysql/data
## nginx项目目录
mkdir -p /home/nginx/www
## nginx配置
mkdir -p /home/nginx/conf
## nginx证书
mkdir -p /home/nginx/cert 
~~~

>运行镜像 memcached redis mysql php nginx
~~~
docker run --name memcached -p 11211:11211 -itd memcached:latest

docker run --name redis -p 6379:6379 \
-v /home/redis/data:/data \
-itd redis:latest \
redis-server --appendonly yes 

docker run --name mysql -p 3306:3306  \
-v /home/mysql/data/:/var/lib/mysql \
-e MYSQL_ROOT_PASSWORD=12345678 \ 
-itd mysql

docker run --name php7.4 -p 9000:9000 \
-v /home/nginx/www/ThinkBIM:/usr/share/nginx/ThinkBIM \
-itd php:7.4.14-fpm

docker run --name nginx -p 80:80 -p 443:443 \
-v /home/nginx/cert/:/etc/nginx/cert/ \
-v /home/nginx/conf/nginx.conf:/etc/nginx/conf.d/thinkbim.conf \
-v /home/nginx/www/ThinkBIM:/usr/share/nginx/ThinkBIM \
 -itd nginx
~~~

## nginx.conf
~~~
vim nginx.conf

## 查看php容器IP
docker inspect php7.4

server {
    listen 80;
    listen 443 ssl;
    ssl_certificate ./cert/www.thinkbim.cn.pem;
    ssl_certificate_key ./cert/www.thinkbim.cn.key;
    root /usr/share/nginx/ThinkBIM/public;
    server_name www.thinkbim.cn thinkbim.cn;
    index  index.html index.htm index.php;
 
    location / {
        try_files $uri @rewrite;
    }
    location @rewrite {
        set $static 0;
        if  ($uri ~ \.(css|js|jpg|jpeg|png|gif|ico|woff|eot|svg|css\.map|min\.map)$) {
            set $static 1;
        }
        if ($static = 0) {
            rewrite ^/(.*)$ /index.php?s=/$1;
        }
    }
    location ~ /Uploads/.*\.php$ {
        deny all;
    }
    location ~ \.php/ {
       if ($request_uri ~ ^(.+\.php)(/.+?)($|\?)) { }
       fastcgi_pass 172.18.0.6:9000;
       include fastcgi_params;
       fastcgi_param SCRIPT_NAME     $1;
       fastcgi_param PATH_INFO       $2;
       fastcgi_param SCRIPT_FILENAME $document_root$1;
    }
    location ~ \.php$ {
        fastcgi_pass 172.18.0.6:9000;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
    location ~ /\.ht {
        deny  all;
    }
}

~~~

## Docker安装[PHP扩展](https://thoughts.teambition.com/share/600640539cda7c004615be32#title=PHP扩展)
>进入PHP容器
~~~
docker exec -it php7.4.14 /bin/bash
~~~

>安装依赖

~~~
apt-get update
apt-get install -y --no-install-recommends libmemcached-dev zlib1g-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev zip unzip git
~~~

>下载安装
~~~
##redis
curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/5.3.2.tar.gz
tar -zxf redis.tar.gz
mv phpredis-5.3.2/ /usr/src/php/ext/
docker-php-ext-install phredis-5.3.2
##memcached
curl -L -o /tmp/memcached.tar.gz https://github.com/php-memcached-dev/php-memcached/archive/v3.1.5.tar.gz
tar -zxf memcached.tar.gz
mv php-memcached-3.1.5/ /usr/src/php/ext/
docker-php-ext-install php-memcached-5.3.2

~~~

> 创建   /usr/src/php/ext 目录
~~~
docker-php-source extract
~~~


> pecl 安装扩展
~~~
pecl install swoole
docker-php-ext-enable swoole
~~~

> 常用扩展
~~~
docker-php-ext-install gd pdo_mysql mysqli bcmath
~~~

> 检查安装

~~~
php -m

[PHP Modules]
Core
ctype
curl
date
dom
fileinfo
filter
ftp
gd
hash
iconv
json
libxml
mbstring
memcached
mysqli
mysqlnd
openssl
pcre
PDO
pdo_mysql
pdo_sqlite
Phar
posix
readline
redis
Reflection
session
SimpleXML
sodium
SPL
sqlite3
standard
swoole
tokenizer
xml
xmlreader
xmlwriter
zlib

[Zend Modules]
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

