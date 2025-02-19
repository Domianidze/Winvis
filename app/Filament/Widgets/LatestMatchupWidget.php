<?php

namespace App\Filament\Widgets;

use App\Models\Matchup;
use Filament\Widgets\Widget;

class LatestMatchupWidget extends Widget
{
    protected static string $view = 'filament.widgets.latest-matchup-widget';

    protected static ?int $sort = 3;

    public ?Matchup $matchup = null;

    public function mount()
    {
        $this->matchup = Matchup::latest()->first();
    }
}
