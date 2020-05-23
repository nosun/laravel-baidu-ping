<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Baidu\Ping\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Larva\Baidu\Ping\Models\BaiduPing;
use Larva\Site\Tool\Baidu;
use Larva\Supports\HttpResponse;

/**
 * 推送 Url 给百度
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduPingJob implements ShouldQueue
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
     * @var string
     */
    protected $site;

    /**
     * @var string
     */
    protected $token;

    /**
     * Create a new job instance.
     *
     * @param BaiduPing $baiduPing
     */
    public function __construct(BaiduPing $baiduPing)
    {
        $this->baiduPing = $baiduPing;
        $this->site = config('services.baidu.site');
        $this->token = config('services.baidu.site_token');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            if ($this->baiduPing->type == BaiduPing::TYPE_SITE) {
                /** @var HttpResponse $response */
                $response = Baidu::Push($this->site, $this->token, $this->baiduPing->url);
                if (isset($response['error'])) {
                    $this->baiduPing->setFailure($response['message']);
                } else {
                    $this->baiduPing->setSuccess();
                }
            } else if ($this->baiduPing->type == BaiduPing::TYPE_DAILY) {
                $response = Baidu::DailyPush($this->site, $this->token, $this->baiduPing->url);
                if (isset($response['error'])) {
                    $this->baiduPing->setFailure($response['message']);
                } else {
                    $this->baiduPing->setSuccess();
                }
            }
        } catch (\Exception $e) {
            $this->baiduPing->setFailure($e->getMessage());
        }
    }
}
