<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends Model
{
    use HasFactory;

    protected $fillable = ["name"];

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }

    protected static function booted(): void
    {
        self::addGlobalScope("ordered", function (Builder $query) {
            $query->orderBy('name');
        });
    }
}
