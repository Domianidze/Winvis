@php
    use App\Filament\Widgets\LatestMatchupWidget;

    /** @var LatestMatchupWidget $this */

    if ($this->matchup) {
        $player1 = $this->matchup->players->first();
        $player2 = $this->matchup->players->last();
    }
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-4">
            <h2 class="h-9 text-lg">Latest Match</h2>
            @if ($this->matchup)
                <div class="flex justify-between items-center gap-4">
                    <div class="flex flex-col gap-4 items-center">
                        <div class="h-32 flex items-center">
                            <x-filament::avatar
                                src="{{ $player1->getFirstMediaUrl('players') }}"
                                size="w-32 object-contain"
                            />
                        </div>
                        <div class="flex items-center gap-1">
                            <p>{{ $player1->name }}</p>
                            @if ($player1->id === $this->matchup->winner_id)
                                <x-filament::icon
                                    icon="heroicon-o-trophy"
                                    class="size-5 text-amber-500"
                                />
                            @endif
                        </div>
                    </div>
                    <p class="pb-10 text-2xl sm:text-4xl">{{ $this->matchup->player1_score }}</p>
                    <div class="pb-10 text-sm text-center">
                        <p>{{ $this->matchup->game->name }}</p>
                        <p class="py-4 text-red-400">vs</p>
                        <p class="text-gray-400">{{ $this->matchup->finish_type ?? 'Regulation' }}</p>
                    </div>
                    <p class="pb-10 text-2xl sm:text-4xl">{{ $this->matchup->player2_score }}</p>
                    <div class="flex flex-col gap-4 items-center">
                        <div class="h-32 flex items-center">
                            <x-filament::avatar
                                src="{{ $player2->getFirstMediaUrl('players') }}"
                                size="w-32"
                            />
                        </div>
                        <div class="flex items-center gap-1">
                            <p>{{ $player2->name }}</p>
                            @if ($player2->id === $this->matchup->winner_id)
                                <x-filament::icon
                                    icon="heroicon-o-trophy"
                                    class="size-5 text-amber-500"
                                />
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <p class="text-center">No matchup found</p>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
