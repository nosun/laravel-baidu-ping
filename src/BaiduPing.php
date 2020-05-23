<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Baidu\Ping;

use Larva\Baidu\Ping\Jobs\UpdateJob;
use Larva\Baidu\Ping\Models\BaiduPing as BaiduPingModel;

/**
 * 百度推送快捷方法
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduPing
{
    /**
     * 推送 Url 给百度
     * @param string $url
     * @return \Larva\Baidu\Ping\Models\BaiduPing
     */
    public static function push($url)
    {
        return BaiduPingModel::firstOrCreate(['url' => $url, 'type' => BaiduPingModel::TYPE_SITE]);
    }

    /**
     * 推送 Url 给百度
     * @param string $url
     * @return \Larva\Baidu\Ping\Models\BaiduPing
     */
    public static function daily($url)
    {
        return BaiduPingModel::firstOrCreate(['url' => $url, 'type' => BaiduPingModel::TYPE_DAILY]);
    }

    /**
     * 推送 Url 给百度
     * @param string $url
     */
    public static function update($url)
    {
        if (($ping = BaiduPingModel::query()->where('url', '=', $url)->first()) != null) {
            $ping->update(['status' => BaiduPingModel::STATUS_PENDING]);
            UpdateJob::dispatch($ping);
        } else {
            static::push($url);
        }
    }

    /**
     * 推送 Url 给百度
     * @param string $url
     * @throws \Exception
     */
    public static function delete($url)
    {
        if (($ping = BaiduPingModel::query()->where('url', '=', $url)->first()) != null) {
            $ping->delete();
        }
    }
}