<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * ファイルリソースの管理を行うクラス
 */
class FileResource extends Resource
{
    /**
     * モデルクラス
     *
     * @var string|null
     */
    protected static ?string $model = File::class;

    /**
     * ナビゲーションアイコン
     *
     * @var string|null
     */
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * フォームを定義するメソッド
     *
     * @param \Filament\Forms\Form $form フォームインスタンス
     * @return \Filament\Forms\Form
     */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('名前')
                ->required(),
    //            Forms\Components\TextInput::make('filename') // ファイル名を追加
    //            ->label('ファイル名'),
            Forms\Components\FileUpload::make('path') // アップロードフィールド
                ->label('ファイルアップロード')
                ->disk('public') // ストレージディスク
                ->directory('uploads') // 保存先ディレクトリ
                ->required()
                ->acceptedFileTypes(['image/*', 'application/pdf', 'text/html'])
                ->maxSize(10240), // 最大サイズ (例: 100 MB)
            Forms\Components\Textarea::make('note')
                ->label('備考')
                ->nullable(),
        ]);
    }

    /**
     * テーブルを定義するメソッド
     *
     * @param \Filament\Tables\Table $table テーブルインスタンス
     * @return \Filament\Tables\Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('名前')
                    ->sortable(),
                Tables\Columns\TextColumn::make('filename')
                    ->label('ファイル名')
                    ->limit(50),
                Tables\Columns\TextColumn::make('path')
                    ->label('ファイルパス')
                    ->limit(100),
                Tables\Columns\TextColumn::make('note')
                    ->label('備考')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新日')
                    ->dateTime(),
            ])
            ->filters([
                // 必要に応じてフィルターを追加
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // 編集アクション
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('bulkDelete')
                    ->label('一括削除')
                    ->icon('heroicon-o-trash')
                    ->action(function ($records) {
                        foreach ($records as $record) {
                            $record->delete();
                        }
                    }),
            ]);
    }

    /**
     * リレーションを定義するメソッド
     *
     * @return array<string, string>
     */
    public static function getRelations(): array
    {
        return [
            // リレーションを追加する場合、ここに定義します。
        ];
    }

    /**
     * ページルートを定義するメソッド
     *
     * @return array<string, string>
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }
}
