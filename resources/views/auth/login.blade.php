@extends('layouts.app')

@section('bodyId', 'body-login')

@section('content')

    <div id="login-panel" class="p1">

        @component('partials.components.panel', ['title' => 'Login'])

            @include('partials.auth.login-form')

            @slot('beneath')
                @include('partials.overview.footer')
            @endslot

        @endcomponent

    </div> {{-- div#login-panel --}}

@endsection
