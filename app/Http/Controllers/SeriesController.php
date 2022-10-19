<?php

namespace App\Http\Controllers;

use App\Events\SeriesCreated as EventsSeriesCreated;
use App\Models\Series;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Repositories\SeriesRepository;
use App\Http\Requests\SeriesFormRequest;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $SeriesRepository)
    {
        $this->middleware('auth')->except('index');
    }

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
        $request->coverPath = $request->hasFile('cover')
            ? $request->file("cover")->store('series_cover', 'public')
            : null;

        $series = $this->SeriesRepository->add($request);

        EventsSeriesCreated::dispatch(
            $series->name,
            $series->id,
            $request->seasonsQtt,
            $request->episodesPerSeason
        );

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
