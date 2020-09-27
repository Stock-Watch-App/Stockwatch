@extends('layouts.app')

@section('content')
    <div class="houseguest-page-wrap">
        <h3 class="mg-btm-lg">{{ $houseguest->nickname }}</h3>

        <projection-item
            :houseguest="{{$houseguest}}"
            :linktohg="false"
        ></projection-item>



        <table class="leaderboard-table">
            <thead>
                <tr>
                    <td></td>
                    @foreach(reset($sortedRatings) as $weekNo => $rating)
                        <td>Week {{$weekNo}}</td>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach($sortedRatings as $lfc => $ratings)
                <tr>
                    <td>{{$lfc}}</td>
                    @foreach($ratings as $rating)
                        <td>{{$rating}}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- <houseguest-rating-table></houseguest-rating-table> -->

       <houseguest-chart></houseguest-chart>
    </div>
@endsection


<!-- @foreach($sortedRatings as $sortedRating) -->
<!-- @endforeach -->
