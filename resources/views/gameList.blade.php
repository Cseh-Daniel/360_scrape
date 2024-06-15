@php
    $count = 0;
    foreach ($games as $array) {
        foreach ($array as $game) {
            $count++;
        }
    }
@endphp
<div>
    <h5>{{ $count }}</h5>
    <ul>
        @foreach ($games as $array)
            @foreach (array_keys($array) as $game)
                <li>{{ $game }}</li>
            @endforeach
        @endforeach
    </ul>
</div>
