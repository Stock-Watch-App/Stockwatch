@extends('layouts.landing_light')

@section('content')
    <div class="landingWrap mg-top-lg" id="landing">
        <div class="flex-col maintenance">
            <div class="logo-wrap">
                @include('logo')
            </div>
            <br>
            <h3 class="mg-bottom-md">The stockwatch is unavailable right now. Thank you for your patience.</h3>
{{--            <h3 class="mg-bottom-md">The stockwatch is unavailable right now to prepare for the roundtable. Tune in tonight at 9:00 ET to watch the LFC rate the houseguests and set prices for this week!</h3>--}}
{{--            <h3>Follow--}}
{{--                <a href="https://twitter.com/ArmstrongTaran" title="Taran on Twitter" class="item-wrap" target="_blank" rel="noreferrer noopener">Taran</a> for the roundtable link--}}
{{--            </h3></div>--}}
    </div>
@endsection
