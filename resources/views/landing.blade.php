@extends('layouts.landing')

@section('content')
<div class="flex flex-col mb-4 container mx-auto px-4 justify-center" id="landing">
    <h1>Register for the Big Brother Canada 8 Stock Watch!</h1>
    <div class="w-1/2 rounded overflow-hidden shadow-lg bg-blue-800 flex flex-col">
        <button><font-awesome-icon :icon="['fab', 'reddit']"/></button>
        <button><font-awesome-icon :icon="['fab', 'twitter']"/></button>
        <button><font-awesome-icon :icon="['fab', 'discord']"/></button>
        <button><font-awesome-icon :icon="['fab', 'facebook']"/></button>
        <button><font-awesome-icon :icon="['fab', 'twitch']"/></button>
    </div>
</div>
@endsection