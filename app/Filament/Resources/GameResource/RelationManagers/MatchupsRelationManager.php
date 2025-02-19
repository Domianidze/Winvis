<?php

namespace App\Filament\Resources\GameResource\RelationManagers;

use App\Models\Matchup;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;

class MatchupsRelationManager extends RelationManager
{
    protected static string $relationship = 'matchups';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('winner.name')
                    ->icon('heroicon-o-trophy')
                    ->iconColor(Color::Amber)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('finish_type')
                    ->label('Finish')
                    ->placeholder('Regulation'),
                Tables\Columns\TextColumn::make('player1_score')
                    ->label('Score')
                    ->placeholder('N/A')
                    ->formatStateUsing(function (Matchup $matchup): string {
                        return $matchup->player1_score . ' - ' . $matchup->player2_score;
                    }),
            ]);
    }
}
