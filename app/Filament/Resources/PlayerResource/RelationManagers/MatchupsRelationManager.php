<?php

namespace App\Filament\Resources\PlayerResource\RelationManagers;

use App\Models\Matchup;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MatchupsRelationManager extends RelationManager
{
    protected static string $relationship = 'matchups';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('game.thumbnail')
                    ->collection('games'),
                Tables\Columns\TextColumn::make('result')
                    ->getStateUsing(fn(Matchup $matchup): string => $matchup->winner_id === $this->getOwnerRecord()->id ? 'Win' : 'Loss')
                    ->icon(fn(string $state): string|null => $state === 'Win' ? 'heroicon-o-trophy' : null)
                    ->iconColor(Color::Amber),
                Tables\Columns\TextColumn::make('finish_type')
                    ->label('Finish')
                    ->placeholder('Regulation'),
                Tables\Columns\TextColumn::make('player1_score')
                    ->label('Score')
                    ->placeholder('N/A')
                    ->formatStateUsing(function (Matchup $matchup): string {
                        return $matchup->player1_score . ' - ' . $matchup->player2_score;
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('won')
                    ->toggle()
                    ->label('Won')
                    ->query(fn(Builder $query): Builder => $query->where('winner_id', $this->getOwnerRecord()->id)),
            ]);
    }
}
