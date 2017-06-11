@extends('layouts.app')

@section('content')

    <div id="overview" class="m4t m1t-xs p1">

        @component('partials.panel', ['title' => 'Speed'])

            @include('partials.overview.average')

        @endcomponent

    </div>
@endsection

@push('scripts')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>

    google.charts.load('current', {'packages': ['corechart']});

    google.charts.setOnLoadCallback(drawChart);

    var data = null;

    // Set chart options
    var options = null;

    var chart = null;

    function drawChart()
    {
        data = google.visualization.arrayToDataTable([
            ['Hour', 'Download', 'Upload'],
                @for($hour = 0; $hour < 24; $hour++)
            ['{{$hour}}', {{$avgDownload[$hour]}}, {{$avgUpload[$hour]}}],
            @endfor
        ]);

        options = {
            hAxis: {title: 'Hour', titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };

        chart = new google.visualization.AreaChart(document.getElementById('bytime'));
        chart.draw(data, options);

        window.chart = chart;
    }

    function resizeChart () {
        chart.draw(data, options);
    }
    if (document.addEventListener) {
        window.addEventListener('resize', resizeChart);
    }
    else if (document.attachEvent) {
        window.attachEvent('onresize', resizeChart);
    }
    else {
        window.resize = resizeChart;
    }

</script>
@endpush