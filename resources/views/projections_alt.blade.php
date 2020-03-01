@extends('layouts.app')

@section('content')
    <div class="projection-wrap">

        @foreach($houseguests as $houseguest)
{{-- Everything in here should be a vue component I think--}}
            <div class="hg-info">
                <img src="{{ $houseguest->avatar }}" alt="{{ $houseguest->nickname }}">
                <h2>{{ $houseguest->nickname }}</h2>
                <div class="stock-value">
                    <h3>This Week</h3>
                    <div class="rating">Rating: {{$houseguest->current_rate}}</div>
                    <div class="price">Price: {{$houseguest->current_price}}</div>
                </div>
            </div>
            <div class="hg-projection">
                <h3>Next Week</h3>
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
        @endforeach
    </div>
@endsection
