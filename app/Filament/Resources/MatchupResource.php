<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatchupResource\Pages;
use App\Filament\Resources\MatchupResource\RelationManagers;
use App\Models\Matchup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MatchupResource extends Resource
{
    protected static ?string $model = Matchup::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('player1_score')
                    ->numeric(),
                Forms\Components\TextInput::make('player2_score')
                    ->numeric(),
                Forms\Components\TextInput::make('finish_type')
                    ->maxLength(255),
                Forms\Components\Select::make('winner_id')
                    ->relationship('winner', 'name'),
                Forms\Components\Select::make('game_id')
                    ->relationship('game', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('player1_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('player2_score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('finish_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('winner.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('game.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMatchups::route('/'),
            'create' => Pages\CreateMatchup::route('/create'),
            'edit' => Pages\EditMatchup::route('/{record}/edit'),
        ];
    }
}
