<?php

namespace App\Filament\Resources\MatchupResource\Pages;

use App\Filament\Resources\MatchupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMatchups extends ListRecords
{
    protected static string $resource = MatchupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
