<?php

namespace App\Http\Controllers\Api;

use App\Models\Series;
use App\Http\Controllers\Controller;

class SeasonsController extends Controller
{
    public function getSeriesSeasons(Series $series)
    {
        return $series->seasons;
    }
}
