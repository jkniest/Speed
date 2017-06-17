<div id="bytime-{{$slot}}" style="width: 100%; height: 200px;"></div>

@push('scripts')

<script>

    google.charts.load('current', {'packages': ['corechart']});

    google.charts.setOnLoadCallback(drawChart_{{$slot}});

    var data_{{$slot}} = null;

    // Set chart options
    var options_{{$slot}} = null;

    var chart_{{$slot}} = null;

    function drawChart_{{$slot}}()
    {
        data_{{$slot}} = google.visualization.arrayToDataTable([
            ['Hour', 'Download', 'Upload'],
                @for($hour = 0; $hour < 24; $hour++)
            [
                '{{$hour}}', {{$downloads[$hour]}}, {{$uploads[$hour]}}],
            @endfor
        ]);

        options_{{$slot}} = {
            hAxis: {title: 'Hour', titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };

        chart_{{$slot}} = new google.visualization.AreaChart(document.getElementById('bytime-{{$slot}}'));
        chart_{{$slot}}.draw(data_{{$slot}}, options_{{$slot}});

        window.chart_{{$slot}} = chart_{{$slot}};
    }

    function resizeChart_{{$slot}}()
    {
        chart_{{$slot}}.draw(data_{{$slot}}, options_{{$slot}});
    }

    if (document.addEventListener) {
        window.addEventListener('resize', resizeChart_{{$slot}});
    } else {
        if (document.attachEvent) {
            window.attachEvent('onresize', resizeChart_{{$slot}});
        } else {
            window.resize = resizeChart_{{$slot}};
        }
    }

</script>

@endpush
