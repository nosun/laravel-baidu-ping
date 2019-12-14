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
        if ($this->app->runningInConsole()) {
            $this->commands('command.baidu.ping');
            $this->commands('command.baidu.ping.retry');
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'baidu-ping');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommand();
    }

    /**
     * Register the MNS queue command.
     * @return void
     */
    private function registerCommand()
    {
        $this->app->singleton('command.baidu.ping', function () {
            return new \Larva\Baidu\Ping\Commands\BaiduPing();
        });

        $this->app->singleton('command.baidu.ping.retry', function () {
            return new \Larva\Baidu\Ping\Commands\BaiduPingRetry();
        });
    }

}