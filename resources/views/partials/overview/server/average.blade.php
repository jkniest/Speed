<div class="w100">

    <div class="columns">

        <div class="column is-half">

            @component('partials.panel', ['title' => 'Average speed', 'icon' => 'line-chart'])

                @include('partials.overview.server.average-speed')

            @endcomponent

        </div> {{-- div.column.is-half --}}

        <div class="column is-half">

            @component('partials.panel', ['title' => 'By time', 'icon' => 'clock-o'])

                @include('partials.overview.server.average-time')

            @endcomponent

        </div> {{-- div.column.is-half --}}

    </div> {{-- div.column --}}

</div> {{-- div.w100 --}}