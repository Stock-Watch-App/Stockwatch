@if((env('APP_ENV') === 'production'))
    <script async defer data-website-id="{{env('UMAMI_SITE_ID')}}" src="{{env('UMAMI_SITE_URL')}}"></script>
@endif
