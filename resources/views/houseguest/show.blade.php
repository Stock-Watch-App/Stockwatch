@extends('layouts.app')

@section('content')
    <div class="houseguest-page-wrap">
        <h2 class="mg-btm-lg">{{ $houseguest->nickname }}</h2>
        <h4 class="mg-btm-sm">Price Projections</h4>
        <x-skeleton style="width:100%;height:126px;border-radius:4px;margin-bottom:1rem"/>
        <projection-item
            :houseguest="{{$houseguest}}"
            :showname="false"
        ></projection-item>

        <h4 class="mg-btm-sm">Ratings Overview</h4>
        <div class="houseguest-dashboard-item mg-btm-lg">
            <table class="table ratings-table">
                <thead>
                <tr>
                    <th></th>
                    @foreach(reset($sortedRatings) as $weekNo => $rating)
                        <th>Week {{ $weekNo }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($sortedRatings as $lfc => $ratings)
                    <tr>
                        <td class="names">{{ $lfc }}</td>
                        @foreach($ratings as $rating)
                            <td>{{ $rating }}</td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <h4 class="mg-btm-sm">Ratings & Price</h4>
        <div class="houseguest-dashboard-item mg-btm-lg chart">
            <houseguest-chart :sorted-ratings="{{ json_encode($sortedRatings) }}" :sorted-prices="{{ json_encode($sortedPrices) }}"></houseguest-chart>
            <div class="mg-top-md">
                <p style="font-size: .75rem; margin-bottom: 0;">To toggle, click the labels at the top of the chart</p>
                <p style="font-size: .75rem">Hover over nodes for more details</p>
            </div>
        </div>

    </div>
@endsection
