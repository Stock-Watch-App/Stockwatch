@extends('layouts.app')

@section('content')
    <div class="projection-wrap">
        <h3>This week's price projections</h3>
        @foreach($houseguests as $houseguest)
            @php

                $houseguest->append('projections');
            @endphp
            <projection-item
                :houseguest="{{$houseguest}}"
            ></projection-item>

        @endforeach
    </div>
@endsection
