<div class="w100">

    <div class="columns">

        <div class="column is-half">

            @component('partials.components.panel', ['title' => 'Average speed', 'icon' => 'line-chart'])

                @include('partials.components.average-info', [
                    'download' => $download,
                    'upload' => $upload
                ])

            @endcomponent

        </div> {{-- div.column.is-half --}}

        <div class="column is-half">

            @component('partials.components.panel', ['title' => 'By time', 'icon' => 'clock-o'])

                @include('partials.components.average-time', [
                    'id' => $id,
                    'downloads' => $timeDownload,
                    'uploads' => $timeUpload
                ])

            @endcomponent

        </div> {{-- div.column.is-half --}}

    </div> {{-- div.column --}}

</div> {{-- div.w100 --}}