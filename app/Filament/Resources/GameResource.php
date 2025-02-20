<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers\MatchupsRelationManager;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')
                        ->collection('games')
                        ->image()
                        ->imageResizeMode('cover')
                        ->imageResizeUpscale(false)
                        ->imageCropAspectRatio('16:9')
                        ->imageResizeTargetHeight('1080')
                        ->imageResizeTargetWidth('1920')
                        ->imagePreviewHeight('250')
                        ->imageEditor()
                        ->maxSize(1024 * 25),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Repeater::make('finish_types')
                        ->schema([
                            Forms\Components\TextInput::make('finish')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->defaultItems(0),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('games'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
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
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make()
                    ->schema([
                        Infolists\Components\SpatieMediaLibraryImageEntry::make('thumbnail')
                            ->collection('games')
                            ->hiddenLabel()
                            ->height(200),
                        Infolists\Components\TextEntry::make('name')
                            ->hiddenLabel()
                            ->size(TextEntrySize::Large),
                        Infolists\Components\RepeatableEntry::make('finish_types')
                            ->schema([
                                Infolists\Components\TextEntry::make('finish')
                                    ->hiddenLabel(),
                            ])
                            ->grid(4),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            MatchupsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'view' => Pages\ViewGame::route('/{record}'),
        ];
    }
}
