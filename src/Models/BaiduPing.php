<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\Baidu\Ping\Models;

use Illuminate\Database\Eloquent\Model;
use Larva\Baidu\Ping\Jobs\BaiduPingJob;

/**
 * Class SearchPush
 * @property int $id
 * @property string $type
 * @property string $url
 * @property int $status
 * @property string $msg
 * @property int $failures
 * @property string $push_at
 * @method static \Illuminate\Database\Eloquent\Builder|BaiduPing failure()
 * @method static \Illuminate\Database\Eloquent\Builder|BaiduPing pending()
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class BaiduPing extends Model
{
    const UPDATED_AT = null;

    const TYPE_SITE = 'site';//站长平台
    const TYPE_MIP = 'mip';//站长平台 MIP
    const TYPE_REALTIME = 'realtime';//移动 天级收录
    const TYPE_BATCH = 'batch';//移动 周级收录

    const STATUS_PENDING = 0b0;//待推送
    const STATUS_SUCCESS = 0b1;//正常
    const STATUS_FAILURE = 0b10;//失败

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'baidu_ping';

    /**
     * 可以批量赋值的属性
     *
     * @var array
     */
    protected $fillable = [
        'url', 'type', 'status', 'msg', 'failures', 'push_at'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            /** @var BaiduPing $model */
            $model->status = static::STATUS_PENDING;
        });
        static::created(function ($model) {
            BaiduPingJob::dispatch($model);
        });
    }

    /**
     * 查询等待的推送
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', static::STATUS_PENDING);
    }

    /**
     * 查询失败的推送
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFailure($query)
    {
        return $query->where('status', static::STATUS_FAILURE);
    }

    /**
     * 设置执行失败
     * @param string $msg
     * @return bool
     */
    public function setFailure($msg)
    {
        return $this->update(['status' => static::STATUS_FAILURE, 'msg' => $msg, 'failures' => $this->failures + 1, 'push_at' => $this->fromDateTime($this->freshTimestamp())]);
    }

    /**
     * 设置推送成功
     * @return bool
     */
    public function setSuccess()
    {
        return $this->update(['status' => static::STATUS_SUCCESS, 'msg' => 'ok', 'failures' => 0, 'push_at' => $this->fromDateTime($this->freshTimestamp())]);
    }
}
