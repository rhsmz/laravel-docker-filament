<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFile extends CreateRecord
{
    protected static string $resource = FileResource::class;

    /**
     * 保存時のロジックをカスタマイズするメソッド
     *
     * @return void
     */
    protected function afterSave(): void
    {
        $record = $this->getRecord();

        // ファイルが保存されている場合に処理
        if ($record->path && is_file(storage_path('app/public/' . $record->path))) {
            // ファイル名を設定
            $record->filename = basename($record->path);
            $record->save();
        }
    }
}
