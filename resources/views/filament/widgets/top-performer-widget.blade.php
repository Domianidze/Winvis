@php
    use App\Filament\Widgets\TopPerformerWidget;

    /** @var TopPerformerWidget $this */

@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col items-center gap-4">
            <div class="w-full h-9 flex justify-between items-center">
                <h2 class="text-lg">Top Performer</h2>
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="game">
                        <option value="">All</option>
                        @foreach ($this->games as $game)
                            <option value="{{ $game->id }}">{{ $game->name }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>
            <x-filament::avatar
                src="{{ $this->topPerformer->getFirstMediaUrl('players') }}"
                size="size-32"
            />
            <div class="flex items-center gap-1">
                <p>{{ $this->topPerformer->name }} - </p>
                <div class="flex items-center gap-1">
                    <x-filament::icon
                        icon="heroicon-o-trophy"
                        class="size-5 text-amber-500"
                    />
                    <p>{{ $this->topPerformer->wins }}</p>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
