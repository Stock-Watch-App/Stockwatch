@extends('layouts.app')

@section('content')
<div class="projection-wrap">
    <table>
    <thead>
        <tr>
        <th class="hg">Cliff</th>
        <th class="this-week">This Week</th>
        <th colspan="10" class="next-week">Next Week</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Rating</th>
            <td>4</td>
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
            <th>Price</th>
            <td>$4</td>
            <td>$1</td>
            <td>$2</td>
            <td>$3</td>
            <td>$4</td>
            <td>$5</td>
            <td>$6</td>
            <td>$7</td>
            <td>$8</td>
            <td>$9</td>
            <td>$10</td>
        </tr>
    </tbody>
    </table>
</div>
@endsection
