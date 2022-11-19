<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Series extends Model
{
    use HasFactory;

    protected $fillable = ["name", "cover"];
    protected $appends = ["links"];

    protected static function booted(): void
    {
        self::addGlobalScope("ordered", function (Builder $query) {
            $query->orderBy('name');
        });
    }

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }

    public function episodes(): HasManyThrough
    {
        return $this->HasManyThrough(Episode::class, Season::class);
    }

    public function links(): Attribute
    {
        return new Attribute(
            get: fn () => [
                [
                    'rel' => 'self',
                    'url' => "/api/series/{$this->id}"
                ],
                [
                    'rel' => 'seasons',
                    'url' => "/api/series/{$this->id}/seasons"
                ],
                [
                    'rel' => 'episodes',
                    'url' => "/api/series/{$this->id}/episodes"
                ]
            ]
        );
    }
}
