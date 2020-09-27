@extends('layouts.app')

@section('content')
    <div class="houseguest-page-wrap">
        <h2 class="mg-btm-lg">{{ $houseguest->nickname }}</h2>
        <h4 class="mg-btm-sm">Price Projections</h4>
        <projection-item
            :houseguest="{{$houseguest}}"
            :show-name="false"
        ></projection-item>

        <h4 class="mg-btm-sm">Ratings Overview</h4>
        <div class="ratings-table-wrap">
            <table class="table ratings-table">
                <thead>
                    <tr>
                        <th></th>
                        @foreach(reset($sortedRatings) as $weekNo => $rating)
                            <th>Week {{$weekNo}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @foreach($sortedRatings as $lfc => $ratings)
                    <tr>
                        <td class="names">{{$lfc}}</td>
                        @foreach($ratings as $rating)
                            <td>{{$rating}}</td>
                        @endforeach
                    </tr>
                @endforeach
                    <tr>
                        <td class="names">Average</td>
                    </tr>
                </tbody>
            </table>
        </div>

       <houseguest-chart></houseguest-chart>
    </div>
@endsection


<!-- @foreach($sortedRatings as $sortedRating) -->
<!-- @endforeach -->
