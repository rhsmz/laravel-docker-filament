<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * タイマーを管理するモデル
 *
 * @package App\Models
 * @property int $id 主キー
 * @property string $uuid UUID
 * @property string $name 名前
 * @property Carbon $date 起動日時
 * @property string $note 備考
 * @property int $file_id 公開ファイルID
 * @property Carbon|null $created_at 作成日時
 * @property Carbon|null $updated_at 更新日時
 */
class Timer extends Model
{
    use HasFactory;

    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'timers';

    /**
     * 主キー
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 自動インクリメントを利用するか
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * 主キーの型
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * 一括代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'date',
        'note',
        'file_id',
    ];

    /**
     * 属性のキャスト
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uuid' => 'string',
        'name' => 'string',
        'date' => 'datetime',
        'note' => 'string',
        'file_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * モデルが生成されるときにUUIDを自動的に生成
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Timer モデルと File モデルのリレーションを定義
     *
     * 多対1 (複数の Timer モデルが 1 つの File モデルに関連付けられています)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
