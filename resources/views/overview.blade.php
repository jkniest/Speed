@extends('layouts.app')

@section('content')

    <div id="overview" class="m4t m1t-xs p1">

        @component('partials.panel')

            @slot('title')

                <div class="level">

                    <div class="level-left">

                        <div class="level-item">

                            All servers

                        </div> {{-- div.level-item --}}

                    </div> {{-- div.level-left --}}

                    <div class="level-right">

                        <div class="level-item">

                            <form action="{{route('logout')}}" id="logoutForm" method="post">
                                {{csrf_field()}}
                            </form>

                            <a href="#" onclick="$('#logoutForm').submit();">
                                [Logout]
                            </a>

                        </div> {{-- div.level-item --}}

                    </div> {{-- div.level-right --}}

                </div> {{-- div.level --}}

            @endslot {{-- slot: title --}}

            @include('partials.overview.average')

        @endcomponent {{-- component: panel --}}

        @include ('partials.overview.all-servers')

        @include('partials.overview.footer')

    </div>

@endsection


