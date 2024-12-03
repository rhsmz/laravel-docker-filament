<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TimerResource\Pages;
use App\Filament\Resources\TimerResource\RelationManagers;
use App\Models\Timer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TimerResource extends Resource
{
    protected static ?string $model = Timer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('名前')
                ->required(),
            Forms\Components\DatePicker::make('date')
                ->label('起動日時')
                ->required(),
            Forms\Components\Textarea::make('note')
                ->label('備考')
                ->nullable(),
            Forms\Components\Select::make('file_id')
                ->relationship('file', 'name')
                ->label('公開ファイル')
                ->required(),
        ]);
    }

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
                Tables\Columns\TextColumn::make('date')
                    ->label('起動日時')
                    ->date(),
                Tables\Columns\TextColumn::make('note')
                    ->label('備考')
                    ->limit(50),
                Tables\Columns\TextColumn::make('file.name')
                    ->label('公開ファイル')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('作成日')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新日')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('file_id')
                    ->label('公開ファイル')
                    ->options(function () {
                        return \App\Models\File::pluck('name', 'id')->toArray();
                    }),
                Tables\Filters\Filter::make('date')
                    ->label('起動日時')
                    ->form([
                        Forms\Components\DatePicker::make('date')
                            ->label('日付')
                            ->required(),
                    ])
                    ->query(function ($query, $data) {
                        if (!empty($data['date'])) {
                            return $query->whereDate('date', $data['date']);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // 編集アクション
                Tables\Actions\DeleteAction::make(), // 削除アクション
                Tables\Actions\Action::make('archive') // アーカイブアクション
                ->label('アーカイブ')
                    ->icon('heroicon-o-archive')
                    ->color('warning')
                    ->action(function (Timer $record) {
                        $record->update(['status' => 'archived']);
                        // 任意で処理を追加
                    }),
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

    public static function getRelations(): array
    {
        return [
            // リレーションを追加する場合、ここに定義します。
            // 例: RelationManagers\YourRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTimers::route('/'),
            'create' => Pages\CreateTimer::route('/create'),
            'edit' => Pages\EditTimer::route('/{record}/edit'),
        ];
    }
}
