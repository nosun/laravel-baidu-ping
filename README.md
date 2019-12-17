# laravel-baidu-ping
百度自动推送

[![Packagist](https://img.shields.io/packagist/l/larva/laravel-baidu-ping.svg?maxAge=2592000)](https://packagist.org/packages/larva/laravel-baidu-ping)
[![Total Downloads](https://img.shields.io/packagist/dt/larva/laravel-baidu-ping.svg?style=flat-square)](https://packagist.org/packages/larva/laravel-baidu-ping)


## Installation

```bash
composer require larva/laravel-baidu-ping
```

## Config

```php
//add services.php
    'baidu'=>[
        //百度站长平台
        'site' => '',//网站域名HTTPS网站需要包含 https://
        'site_token' => '',//网站Token
              
        //百度移动搜索平台
        'app_id' => '',
        'token' => '',
    ]
```

## 使用
```php
\Larva\Baidu\Ping\BaiduPing::push('https://www.aa.com');
```