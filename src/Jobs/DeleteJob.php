<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace Larva\Baidu\Ping\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Larva\Baidu\Ping\Models\BaiduPing;
use Larva\Site\Tool\Baidu;
use Larva\Supports\HttpResponse;

/**
 * 删除推送
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DeleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 2;

    /**
     * @var BaiduPing
     */
    protected $baiduPing;

    /**
     * Create a new job instance.
     *
     * @param BaiduPing $baiduPing
     */
    public function __construct(BaiduPing $baiduPing)
    {
        $this->baiduPing = $baiduPing;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            /** @var HttpResponse $response */
            Baidu::Delete(config('services.baidu.site'), config('services.baidu.site_token'), $this->baiduPing->url);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}