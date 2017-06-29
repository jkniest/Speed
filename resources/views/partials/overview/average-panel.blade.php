@component('partials.components.panel')

    @slot('title')

        @include('partials.overview.average-panel.title')

    @endslot {{-- slot: title --}}

    {{-- Show the average and time panel --}}
    @include('partials.components.double-panel', [
        'download' => $averageDownload,
        'upload' => $averageUpload,
        'id' => 'all',
        'timeDownload' => $avgDownload,
        'timeUpload' => $avgUpload
    ])

@endcomponent {{-- component: panel --}}