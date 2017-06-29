@extends('layouts.app')

@section('content')

    <div id="overview" class="m4t m1t-xs p1">

        @include('partials.overview.average-panel')

        @include('partials.overview.server-list')

        @include('partials.overview.create-server')

        @include('partials.overview.footer')

    </div>

@endsection


