# laravel-baidu-ping
百度自动推送

## Installation

```bash
composer require larva/laravel-baidu-ping
```

## Config

```php
//add services.php
    'baidu'=>[
        //百度站长平台
        site' => '',//网站域名HTTPS网站需要包含 https://
        site_token' => '',//网站Token
              
        //百度移动搜索平台
        'app_id' => '',
        'token' => '',
    ]
```