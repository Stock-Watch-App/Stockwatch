@extends('errors::illustrated-layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
    @if(Session::has('error'))
        {{Session::get('error') }}
    @else
       Something went wrong.
    @endif
@endsection
@section('image')
    <div class="content">
    @if(app()->bound('sentry') && app('sentry')->getLastEventId())
        <div class="subtitle">Error ID: {{ app('sentry')->getLastEventId() }}</div>
        <script>
            Sentry.init({ dsn: {{ env('SENTRY_LARAVEL_DSN') }} });
            Sentry.showReportDialog({ eventId: '{{ app('sentry')->getLastEventId() }}' });
        </script>
    @endif
</div>
@endsection
