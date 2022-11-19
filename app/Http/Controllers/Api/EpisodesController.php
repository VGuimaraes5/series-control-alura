<?php

namespace App\Http\Controllers\Api;

use App\Models\Series;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EpisodesController extends Controller
{
    public function getSeriesEpisodes(Series $series)
    {
        return $series->episodes;
    }

    public function update(Episode $episode, Request $request)
    {
        $episode->watched = $request->watched;
        $episode->save();

        return $episode;
    }
}
