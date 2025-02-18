<?php

namespace App\Filament\Resources\MatchupResource\Pages;

use App\Filament\Resources\MatchupResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMatchup extends ViewRecord
{
    protected static string $resource = MatchupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->slideOver(),
            Actions\DeleteAction::make(),
        ];
    }
}
