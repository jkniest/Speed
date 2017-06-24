@foreach($servers as $server)

    <server-panel inline-template :server="{{$server}}">

        @component('partials.components.panel')

            @slot('title')

                @include('partials.overview.server-panel.title')

            @endslot {{-- slot: title --}}

            {{-- Average stats: Default view --}}
            <div class="w100" v-show="!settingsOpen">
                @include('partials.components.double-panel', [
                    'download' => $server->getAverageDownload(),
                    'upload' => $server->getAverageUpload(),
                    'id' => $server->id,
                    'timeDownload' => $server->getAverageDownloadArray(),
                    'timeUpload' => $server->getAverageUploadArray()
                ])
            </div>

            {{-- Settings panel --}}
            <div v-show="settingsOpen" class="w100">
                @include('partials.components.settings-panel')
            </div>

        @endcomponent {{-- component: panel --}}

    </server-panel>

@endforeach