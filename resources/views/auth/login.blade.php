@extends('layouts.app')

@section('content')

    <div id="login-panel">

        @component('partials.panel', ['title' => 'Login'])

            @include('partials.auth.login-form')

        @endcomponent

    </div> {{-- div#login-panel --}}

@endsection
