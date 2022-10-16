<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EpisodesController extends Controller
{
    public function index(Season $season): View
    {
        $episodes = $season->episodes;
        $successMessage = session('success.message');

        return view('episodes.index')
            ->with('season', $season)
            ->with('episodes', $episodes)
            ->with('successMessage', $successMessage);
    }


    public function update(Request $request, Season $season): Redirector|RedirectResponse
    {
        $watchedEpisodes = $request->episodes;

        $season->episodes->each(function (Episode $episode) use ($watchedEpisodes) {
            $episode->watched = in_array($episode->id, $watchedEpisodes ?? []);
        });

        $season->push();

        return to_route('episodes.index', $season->id)
            ->with('success.message', "lesta de episódios atualizada com sucesso");
    }
}
