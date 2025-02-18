<?php

namespace App\Filament\Resources\GameResource\RelationManagers;

use App\Models\Matchup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MatchupsRelationManager extends RelationManager
{
    protected static string $relationship = 'matchups';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('game.name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('game.name')
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
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
