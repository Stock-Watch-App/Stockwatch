@extends('layouts.app')

@section('content')
    <div class="projection-wrap">

        @foreach($houseguests as $houseguest)
{{-- Everything in here should be a vue component I think--}}
            <div class="projection-card">
                <div class="hg-details">
                    <h5>{{ $houseguest->nickname }}</h5>
                </div>
                <div class="hg-img">
                    <img src="/storage/avatar-default.svg" alt="{{ $houseguest->nickname }}">
                </div>
                <div class="this-week">
                    <h5>This week</h5>
                    <span class="rating-wrap">
                        <h3 class="num-wrap flex-row">
                            <font-awesome-icon icon="star" class="hg-star"/>
                            <span class="hg-star-rating">{{$houseguest->current_rate}}</span>
                            <span class="hg-star-outof"> /10</span>
                        </h3>
                    </span>
                    <div class="price">$ {{$houseguest->current_price}}</div>
                </div>
                <!-- <div class="stock-value">
                    <h3>This Week</h3>
                    <div class="rating">Rating: {{$houseguest->current_rate}}</div>
                    <div class="price">$ {{$houseguest->current_price}}</div>
                </div> -->

                <div class="next-week">
                    <h5>Next Week</h5>
                    <table>
                        <tbody>
                        <tr>
                            <th>Rating:</th>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>5</td>
                            <td>6</td>
                            <td>7</td>
                            <td>8</td>
                            <td>9</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <th>Price:</th>
                            <td>${{ $houseguest->projections['to1'] }}</td>
                            <td>${{ $houseguest->projections['to2'] }}</td>
                            <td>${{ $houseguest->projections['to3'] }}</td>
                            <td>${{ $houseguest->projections['to4'] }}</td>
                            <td>${{ $houseguest->projections['to5'] }}</td>
                            <td>${{ $houseguest->projections['to6'] }}</td>
                            <td>${{ $houseguest->projections['to7'] }}</td>
                            <td>${{ $houseguest->projections['to8'] }}</td>
                            <td>${{ $houseguest->projections['to9'] }}</td>
                            <td>${{ $houseguest->projections['to10'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection
