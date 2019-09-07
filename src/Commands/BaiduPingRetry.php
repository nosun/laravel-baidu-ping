<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Baidu\Ping\Commands;

use App\Jobs\SearchPushJob;
use Illuminate\Console\Command;
use Larva\Baidu\Ping\Jobs\BaiduPingJob;
use Larva\Baidu\Ping\Models\BaiduPing;

/**
 * BaiduPingRetry
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduPingRetry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'baidu:ping-retry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Baidu ping retry.';

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
     */
    public function handle()
    {
        $count = BaiduPing::failure()->count();
        $bar = $this->output->createProgressBar($count);
        BaiduPing::failure()->orderBy('push_at', 'asc')->chunk(100, function ($results) use ($bar) {
            /** @var BaiduPing $ping */
            foreach ($results as $ping) {
                BaiduPingJob::dispatch($ping);
                $bar->advance();
            }
        });
        $bar->finish();
    }
}
