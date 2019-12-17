<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Ping\Commands;

use Illuminate\Console\Command;
use Larva\Baidu\Ping\Models\BaiduPing;

/**
 * 将所有已经推送过的重新推送一次
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BiaduPingRenew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'baidu:ping-renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'baidu renew ping.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        BaiduPing::query()->where('included', 0)->update(['status' => BaiduPing::STATUS_PENDING]);
    }
}
