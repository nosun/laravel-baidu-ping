<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Baidu\Ping;

use Illuminate\Support\ServiceProvider;

/**
 * Class BaiduPingServiceProvider
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduPingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->loadViewsFrom(__DIR__.'/../resources/views', 'passport');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'baidu-ping');

            $this->publishes([
                dirname(__DIR__) . '/config/baidu-ping.php' => config_path('baidu-ping.php'),],
                'baidu-ping'
            );
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

}