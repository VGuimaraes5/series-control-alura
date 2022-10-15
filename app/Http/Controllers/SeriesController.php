<?php

namespace App\Http\Controllers;

use App\Models\Series;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;

class SeriesController extends Controller
{
    public function index(): View
    {
        $series = Series::all();
        $successMessage = session('success.message');

        return view('series.index')
            ->with('series', $series)
            ->with('successMessage', $successMessage);
    }

    public function create(): View
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request): Redirector|RedirectResponse
    {
        $series = Series::create($request->all());

        $seasons = [];
        for ($i = 1; $i <= $request->seasonsQtt; $i++) {
            $seasons[] = [
                "series_id" => $series->id,
                "number" => $i
            ];
        }
        Season::insert($seasons);

        $episodes = [];
        foreach ($series->seasons as $season) {
            for ($i = 1; $i <= $request->episodesPerSeason; $i++) {
                $episodes[] = [
                    "season_id" => $season->id,
                    "number" => $i
                ];
            }
        }
        Episode::insert($episodes);

        return to_route('series.index')
            ->with('success.message', "Série {$series->name} adicionada com sucesso");
    }

    public function edit(Series $series): View
    {
        return view('series.edit')->with('series', $series);
    }

    public function update(SeriesFormRequest $request, Series $series): Redirector|RedirectResponse
    {
        $series->update($request->all());

        return to_route('series.index')
            ->with('success.message', "Série {$series->name} editada com sucesso");
    }

    public function destroy(Series $series): Redirector|RedirectResponse
    {
        $series->delete();

        return to_route('series.index')
            ->with('success.message', "Série {$series->name} removida com sucesso");
    }
}
