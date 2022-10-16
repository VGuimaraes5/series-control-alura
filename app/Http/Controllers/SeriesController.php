<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Series;
use App\Mail\SeriesCreated;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Repositories\SeriesRepository;
use App\Http\Requests\SeriesFormRequest;
use Carbon\Carbon;

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
        $series = $this->SeriesRepository->add($request);

        foreach (User::all() as $index => $user) {
            $email = new SeriesCreated(
                $series->name,
                $series->id,
                $request->seasonsQtt,
                $request->episodesPerSeason
            );

            $when = now()->addSeconds(5 * $index);
            Mail::to($user)->later($when, $email);
        }

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
