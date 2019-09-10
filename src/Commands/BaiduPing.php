<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Baidu\Ping\Commands;

use Illuminate\Console\Command;
use Larva\Baidu\Ping\Jobs\BaiduPingJob;

/**
 * BaiduPing
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduPing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'baidu:ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Baidu ping';

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
        $count = \Larva\Baidu\Ping\Models\BaiduPing::pending()->count();
        $bar = $this->output->createProgressBar($count);
        \Larva\Baidu\Ping\Models\BaiduPing::pending()->orderBy('push_at', 'asc')->chunk(100, function ($results) use ($bar) {
            /** @var \Larva\Baidu\Ping\Models\BaiduPing $ping */
            foreach ($results as $ping) {
                BaiduPingJob::dispatch($ping);
                $bar->advance();
            }
        });
        $bar->finish();
    }
}
