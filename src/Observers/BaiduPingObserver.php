<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Ping\Observers;

use Larva\Baidu\Ping\Jobs\BaiduPingJob;
use Larva\Baidu\Ping\Jobs\DeleteJob;
use Larva\Baidu\Ping\Models\BaiduPing;

/**
 * 模型观察者
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduPingObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param BaiduPing $baiduPing
     * @return void
     */
    public function created(BaiduPing $baiduPing)
    {
        BaiduPingJob::dispatch($baiduPing);
    }

    /**
     * 处理 BaiduPing「删除」事件
     *
     * @param BaiduPing $baiduPing
     * @return void
     */
    public function deleted(BaiduPing $baiduPing)
    {
        DeleteJob::dispatch($baiduPing);
    }
}