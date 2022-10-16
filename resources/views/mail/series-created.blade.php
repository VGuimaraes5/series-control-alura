@component('mail::message')
# {{ $seriesName }} criada
A série {{ $seriesName }} com {{ $seasonsQtt }} temporadas e {{ $episodesPerSeason }} episódios por temporada foi adicionada

Acesse aqui:
@component('mail::button', ['url' => route('seasons.index', $seriesId)])
    Ver série
@endcomponent

@endcomponent
