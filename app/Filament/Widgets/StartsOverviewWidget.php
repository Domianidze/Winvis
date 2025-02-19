<?php

namespace App\Filament\Widgets;

use App\Models\Game;
use App\Models\Matchup;
use App\Models\Player;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StartsOverviewWidget extends BaseWidget
{

    protected function getStats(): array
    {
        return [
            Stat::make('Games', Game::count())
                ->icon('heroicon-o-puzzle-piece')
                ->chart([0, Game::count()])
                ->color(Color::Red),
            Stat::make('Matchups', Matchup::count())
                ->icon('heroicon-o-arrows-up-down')
                ->chart([0, Matchup::count()])
                ->color(Color::Red),
            Stat::make('Player', Player::count())
                ->icon('heroicon-o-user-group')
                ->chart([0, Matchup::count()])
                ->color(Color::Red),
        ];
    }
}
