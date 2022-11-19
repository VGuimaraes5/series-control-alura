<?php

namespace App\Http\Controllers\Api;

use App\Models\Series;
use App\Http\Controllers\Controller;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use App\Http\Requests\SeriesFormRequest;
use Illuminate\Contracts\Auth\Authenticatable;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository)
    {
    }

    public function index(Request $request)
    {
        $query = Series::query();
        if ($request->has('name')) {
            $query->where('name', $request->name);
        }

        return $query->paginate(5);
    }

    public function show(int $seriesId)
    {
        $series = Series::with('seasons.episodes')->find($seriesId);
        if (empty($series)) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        return $series;
    }

    public function store(SeriesFormRequest $request)
    {
        return response()->json(
            $this->seriesRepository->add($request),
            201
        );
    }

    public function update(Series $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return $series;
    }

    public function destroy(int $seriesId, Authenticatable $user)
    {
        if ($user->tokenCan('series:destroy') === false) {
            return response()->json("Unauthorized", 401);
        }

        Series::destroy($seriesId);
        return response()->noContent();
    }
}
