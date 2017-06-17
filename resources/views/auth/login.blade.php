@extends('layouts.app')

@section('bodyId', 'body-login')

@section('content')

    <div id="login-panel" class="p1">

        @component('partials.panel', ['title' => 'Login'])

            @include('partials.auth.login-form')

        @endcomponent

    </div> {{-- div#login-panel --}}

@endsection
