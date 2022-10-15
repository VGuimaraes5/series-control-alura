<x-layout title="Nova Série">

    <form action="{{ route('series.store') }}" method="post">
        @csrf

        <div class="row mb-3">
            <div class="col-sm-6">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" autofocus class="form-control" name="name" id="name"
                    value="{{ old('name') }}">
            </div>
            <div class="col-sm-3">
                <label for="seasonsQtt" class="form-label">Nº Temporadas:</label>
                <input type="text" class="form-control" name="seasonsQtt" id="seasonsQtt"
                    value="{{ old('seasonsQtt') }}">
            </div>
            <div class="col-sm-3">
                <label for="episodesPerSeason" class="form-label">Nº Eps/Temporada:</label>
                <input type="text" class="form-control" name="episodesPerSeason" id="episodesPerSeason"
                    value="{{ old('episodesPerSeason') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

</x-layout>
