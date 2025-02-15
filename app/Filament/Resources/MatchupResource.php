<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MatchupResource\Pages;
use App\Models\Game;
use App\Models\Matchup;
use App\Models\Player;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class MatchupResource extends Resource
{
    protected static ?string $model = Matchup::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-up-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Select::make('game_id')
                        ->relationship('game', 'name')
                        ->searchable()
                        ->preload()
                        ->live()
                        ->required(),
                    Forms\Components\Select::make('players')
                        ->relationship('players', 'name')
                        ->searchable()
                        ->preload()
                        ->multiple()
                        ->live()
                        ->minItems(2)
                        ->maxItems(2)
                        ->required(),
                    Forms\Components\Select::make('winner_id')
                        ->label('Winner')
                        ->options(fn(Get $get): Collection => Player::whereIn('id', $get('players'))->pluck('name', 'id'))
                        ->searchable()
                        ->disabled(fn(Get $get): bool => !$get('players'))
                        ->required(),
                    Forms\Components\Select::make('finish_type')
                        ->options(function (Get $get): Collection {
                            $game = Game::find($get('game_id'));

                            if (!$game) {
                                return collect();
                            }

                            return collect($game->finish_types)
                                ->mapWithKeys(fn($finish): array => [$finish['finish'] => $finish['finish']]);
                        })
                        ->searchable()
                        ->live()
                        ->disabled(fn(Get $get): bool => !$get('game_id')),
                    Forms\Components\Fieldset::make('Score')
                        ->schema([
                            ...collect([1, 2])->map(
                                function (int $player) {
                                    $required = fn(Get $get): bool => $get('finish_type') === null;

                                    return Forms\Components\TextInput::make("player{$player}_score")
                                        ->hiddenLabel()
                                        ->numeric()
                                        ->default(0)
                                        ->dehydrated($required)
                                        ->required($required);
                                }
                            )->all()
                        ])
                        ->disabled(fn(Get $get): bool => $get('finish_type') !== null),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('game.thumbnail')
                    ->collection('games'),
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
                Tables\Filters\SelectFilter::make('game')
                    ->relationship('game', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                Tables\Filters\SelectFilter::make('winner')
                    ->relationship('winner', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
                Tables\Filters\TernaryFilter::make('player1_score')
                    ->label('Regulation')
                    ->nullable(),
                Tables\Filters\SelectFilter::make('finish_type')
                    ->label('Finish')
                    ->options(
                        fn(): Collection => Game::all()
                            ->pluck('finish_types')
                            ->flatten()
                            ->unique()
                            ->mapWithKeys(fn($finish): array => [$finish => $finish])
                    )
                    ->searchable()
                    ->preload()
                    ->multiple(),
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
