<div id="bytime-{{$id}}" class="w100" style="height: 200px;"></div>

@push('scripts')

<script>

    google.charts.load('current', {'packages': ['corechart']});

    google.charts.setOnLoadCallback(drawChart_{{$id}});

    var data_{{$id}} = null;

    // Set chart options
    var options_{{$id}} = null;

    var chart_{{$id}} = null;

    function drawChart_{{$id}}()
    {
        data_{{$id}} = google.visualization.arrayToDataTable([
            ['Hour', 'Download', 'Upload'],
                @for($hour = 0; $hour < 24; $hour++)
            [
                '{{$hour}}', {{$downloads[$hour]}}, {{$uploads[$hour]}}],
            @endfor
        ]);

        options_{{$id}} = {
            hAxis: {title: 'Hour', titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };

        chart_{{$id}} = new google.visualization.AreaChart(document.getElementById('bytime-{{$id}}'));
        chart_{{$id}}.draw(data_{{$id}}, options_{{$id}});

        window.chart_{{$id}} = chart_{{$id}};
    }

    function resizeChart_{{$id}}()
    {
        chart_{{$id}}.draw(data_{{$id}}, options_{{$id}});
    }

    if (document.addEventListener) {
        window.addEventListener('resize', resizeChart_{{$id}});
    } else {
        if (document.attachEvent) {
            window.attachEvent('onresize', resizeChart_{{$id}});
        } else {
            window.resize = resizeChart_{{$id}};
        }
    }

</script>

@endpush
