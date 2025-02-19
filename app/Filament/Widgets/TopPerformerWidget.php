<?php

namespace App\Filament\Widgets;

use App\Models\Game;
use App\Models\Player;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TopPerformerWidget extends Widget
{
    protected static string $view = 'filament.widgets.top-performer-widget';

    public ?Collection $games = null;

    public ?int $game = null;

    public function mount()
    {
        $this->games = Game::all();
    }

    public function getTopPerformerProperty(): Player
    {
        return Player
            ::withCount([
                'matchups as wins' => function (Builder $query) {
                    $query->whereColumn('winner_id', 'players.id');

                    if ($this->game) {
                        $query->where('game_id', $this->game);
                    }
                }
            ])
            ->orderByDesc('wins')
            ->first();
    }
}
