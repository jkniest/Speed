@extends('layouts.app')

@section('content')

    <div id="overview" class="m4t m1t-xs p1">

        @component('partials.panel', ['title' => 'All servers'])

            @include('partials.overview.average')

        @endcomponent

        @include ('partials.overview.all-servers')

        @include('partials.overview.footer')

    </div>

@endsection


