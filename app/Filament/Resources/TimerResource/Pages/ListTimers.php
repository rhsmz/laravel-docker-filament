<?php

namespace App\Filament\Resources\TimerResource\Pages;

use App\Filament\Resources\TimerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimers extends ListRecords
{
    protected static string $resource = TimerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
