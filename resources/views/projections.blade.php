@extends('layouts.app')

@section('content')
    <div class="projection-wrap">
        <h3 class="mg-btm-lg">Price Projections</h3>
        @foreach($houseguests as $houseguest)
            <projection-item
                :houseguest="{{$houseguest}}"
            ></projection-item>
        @endforeach
    </div>
@endsection
