@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
                                            <div class="card-body" style="overflow-x: auto;">
                                                <h6 class="card-title">Struktur Organisasi</h6>
                                                <div id="chart_div" style="min-width: 1000px; height: 800px;"></div>            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages:['orgchart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');

        // For each orgchart box, provide the name, manager, and tooltip to show.
        data.addRows({!! $chartData !!});

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true.
        chart.draw(data, {allowHtml:true});
    }
</script>
@endpush
