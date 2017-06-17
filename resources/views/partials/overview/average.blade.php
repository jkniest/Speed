@component('partials.overview.components.server-panel')

    @slot('average')

        @component('partials.overview.components.speed-panel', [
            'download' => $averageDownload,
            'upload'   => $averageUpload
        ])

        @endcomponent {{-- component: speed-panel --}}


    @endslot {{-- slot - average --}}

    @slot('time')

        @component('partials.overview.components.time-panel', [
            'downloads' => $avgDownload,
            'uploads'   => $avgUpload
        ])

            all

        @endcomponent {{-- component: time-panel --}}

    @endslot {{-- slot - time --}}

@endcomponent
