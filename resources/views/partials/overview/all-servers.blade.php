@foreach($servers as $server)

    @component('partials.panel', ['icon' => 'server'])

        @slot('title')

            {{$server->name}}
            <small>(Last test: {{Carbon\Carbon::parse($server->last_test)->format('d.m.Y H:m')}})</small>

        @endslot

        @component('partials.overview.components.server-panel')

            @slot('average')

                @component('partials.overview.components.speed-panel', [
                    'download' => $server->getAverageDownload(),
                    'upload'   => $server->getAverageUpload(),
                ])
                @endcomponent {{-- component: speed-panel --}}

            @endslot {{-- slot - average --}}

            @slot('time')

                @component('partials.overview.components.time-panel', [
                    'downloads' => $server->getAverageDownloadArray(),
                    'uploads'   => $server->getAverageUploadArray()
                ])

                    {{$server->id}}

                @endcomponent {{-- component: time-panel --}}

            @endslot {{-- slot - time --}}

        @endcomponent {{-- component: server-panel --}}

    @endcomponent {{-- component: panel --}}

@endforeach