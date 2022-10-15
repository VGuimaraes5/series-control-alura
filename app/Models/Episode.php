<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ["number"];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }
}
