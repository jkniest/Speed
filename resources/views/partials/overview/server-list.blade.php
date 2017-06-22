@foreach($servers as $server)

    <server-panel inline-template server="{{$server}}">

        @component('partials.components.panel')

            @slot('title')

                @include('partials.overview.server-panel.title')

            @endslot {{-- slot: title --}}

            {{-- Show the average and time panel --}}
            @include('partials.components.double-panel', [
                'download' => $server->getAverageDownload(),
                'upload' => $server->getAverageUpload(),
                'id' => $server->id,
                'timeDownload' => $server->getAverageDownloadArray(),
                'timeUpload' => $server->getAverageUploadArray()
            ])

        @endcomponent {{-- component: panel --}}

    </server-panel>

@endforeach