<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Contracts\View\View;

class SeasonsController extends Controller
{
    public function index(Series $series): View
    {
        $seasons = $series->seasons()->with('episodes')->get();

        return view('seasons.index')
            ->with('seasons', $seasons)
            ->with('series', $series);
    }
}
