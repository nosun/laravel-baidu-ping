<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Baidu\Ping;

use Larva\Baidu\Ping\Models\BaiduPing as BaiduPingModel;

/**
 * Class BaiduPing
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
        return static::push($url, BaiduPingModel::TYPE_REALTIME);
    }

    /**
     * 周级收录
     * @param string $url
     * @return
     */
    public static function pushBatch($url)
    {
        return static::push($url, BaiduPingModel::TYPE_BATCH);
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