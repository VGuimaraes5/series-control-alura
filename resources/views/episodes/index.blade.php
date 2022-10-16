<x-layout title="Episódios {{ $season->number }}ª temporada" :success-message="$successMessage">
    <form action="{{ route('episodes.update', $season->id) }}" method="POST">
        @csrf
        @method('PUT')

        <ul class="list-group">
            @foreach ($episodes as $episode)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Episódio {{ $episode->number }}

                    <input type="checkbox" name="episodes[]" value="{{ $episode->id }}"
                        @if ($episode->watched) checked @endif>
                </li>
            @endforeach
        </ul>

        <button type="submit" class="btn btn-primary mb-2 mt-2">Salvar</button>
    </form>
</x-layout>
