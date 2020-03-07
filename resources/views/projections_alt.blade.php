@extends('layouts.app')

@section('content')
    <div class="projection-wrap">

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
