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
                <!-- <th>Week</th>
                <th>Brent</th>
                <th>Melissa</th>
                <th>Taran</th>
                <th>Audience</th> -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    
                    <!-- <td></td>
                    <td></td>
                    <td></td>
                    <td></td> -->
                </tr>
            </tbody>
        </table>

        <!-- <houseguest-rating-table></houseguest-rating-table> -->

       <houseguest-chart></houseguest-chart>
    </div>
@endsection

<!-- @dump($sortedRatings) -->
        
<!-- @foreach($sortedRatings as $sortedRating) -->
<!-- @endforeach -->
