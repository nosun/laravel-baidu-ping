<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Baidu\Ping;

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
     * @param null $type
     * @return
     */
    public static function push($url, $type = BaiduPingModel::TYPE_SITE)
    {
        return BaiduPingModel::firstOrCreate(['url' => $url, 'type' => $type]);
    }

    /**
     * 天级收录
     * @param string $url
     * @return
     */
    public static function pushRealtime($url)
    {
        if (config('services.baidu.app_id')) {
            return static::push($url, BaiduPingModel::TYPE_REALTIME);
        }
        return static::push($url);
    }

    /**
     * 周级收录
     * @param string $url
     * @return
     */
    public static function pushBatch($url)
    {
        if (config('services.baidu.app_id')) {
            return static::push($url, BaiduPingModel::TYPE_BATCH);
        }
        return static::push($url);
    }

    /**
     * 推MIP
     * @param string $url
     * @return mixed
     */
    public static function pushMip($url)
    {
        return static::push($url, BaiduPingModel::TYPE_MIP);
    }
}