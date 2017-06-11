@extends('layouts.app')

@section('bodyId', 'body-login')

@section('content')

    <div id="login-panel">

        @component('partials.panel', ['title' => 'Login'])

            @include('partials.auth.login-form')

        @endcomponent

    </div> {{-- div#login-panel --}}

@endsection
