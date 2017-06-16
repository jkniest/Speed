@foreach($servers as $server)

    @component('partials.panel', ['title' => $server->name, 'icon' => 'server'])

        @include('partials.overview.server.average')

    @endcomponent

@endforeach