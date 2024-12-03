<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // UUID生成に必要

/**
 * ファイル管理を行うモデル
 *
 * @property int $id 主キー
 * @property string $uuid UUID
 * @property string $name 名前
 * @property string $filename ファイル名
 * @property string $path ファイルパス
 * @property string $note 備考
 * @property \Illuminate\Support\Carbon|null $created_at 作成日時
 * @property \Illuminate\Support\Carbon|null $updated_at 更新日時
 */
class File extends Model
{
    use HasFactory;

    /**
     * テーブル名
     *
     * @var string
     */
    protected $table = 'files';

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
        'filename',
        'path',
        'note',
    ];

    /**
     * 属性のキャスト
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uuid' => 'string',
        'name' => 'string',
        'filename' => 'string',
        'path' => 'string',
        'note' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * モデルの保存時に呼ばれるイベント
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($file) {
            // UUIDが設定されていない場合に生成
            if (empty($file->uuid)) {
                $file->uuid = Str::uuid()->toString();
            }

            // ファイルのパスが設定されている場合
            if ($file->path and is_file($file->path)) {
                // アップロードされたファイルをストレージに保存し、ファイルパスを取得
                $filePath = Storage::disk('public')->put('uploads', $file->path);

                // パスをモデルに設定
                $file->path = $filePath;
            }

            if (empty($file->filename) and $file->path and is_file($file->path)){
                // アップロードされたファイルをストレージに保存し、ファイルパスを取得
                $filePath = Storage::disk('public')->put('uploads', $file->path);
                // ファイル名を設定
                $file->filename = basename($filePath);
            }
        });
    }
}
