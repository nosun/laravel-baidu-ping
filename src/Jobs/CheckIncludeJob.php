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
use Larva\Baidu\Ping\Models\BaiduPing;
use Larva\Site\Tool\Baidu;

/**
 * 检查百度是否收录
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CheckIncludeJob implements ShouldQueue
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
        $included = Baidu::checkInclude($this->baiduPing->url);
        if ($included) {
            $this->baiduPing->setIncluded();
        }
    }
}