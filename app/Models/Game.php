<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Game extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'finish_types' => 'array',
    ];

    public function matchups(): HasMany
    {
        return $this->hasMany(Matchup::class);
    }
}
