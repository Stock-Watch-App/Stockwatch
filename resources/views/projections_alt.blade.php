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
                            <span class="hg-star-rating">{$houseguest->current_rate}</span>
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
                            <td>${{ $houseguest->projection['to1'] }}</td>
                            <td>${{ $houseguest->projection['to2'] }}</td>
                            <td>${{ $houseguest->projection['to3'] }}</td>
                            <td>${{ $houseguest->projection['to4'] }}</td>
                            <td>${{ $houseguest->projection['to5'] }}</td>
                            <td>${{ $houseguest->projection['to6'] }}</td>
                            <td>${{ $houseguest->projection['to7'] }}</td>
                            <td>${{ $houseguest->projection['to8'] }}</td>
                            <td>${{ $houseguest->projection['to9'] }}</td>
                            <td>${{ $houseguest->projection['to10'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection
