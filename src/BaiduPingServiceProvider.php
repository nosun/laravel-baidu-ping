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
            $this->commands('command.baidu.ping.renew');
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }

        \Larva\Baidu\Ping\Models\BaiduPing::observe(\Larva\Baidu\Ping\Observers\BaiduPingObserver::class);
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

        $this->app->singleton('command.baidu.ping.renew', function () {
            return new \Larva\Baidu\Ping\Commands\BiaduPingRenew();
        });
    }

}