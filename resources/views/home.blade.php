@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><p class="m-0">{{ date('j F Y \, l') }}</p></div>

                <div class="card-body p-0">

                @foreach($items as $item)
                    <!-- {{$items[0]->sales}} -->
                    <?php $count = count($items[0]->sales) - 1;?>
                    <div class="container card bg-dark text-white text-center mb-1">
                        <div class="row row-cols-2 row-cols-md-4 pt-3 card-img-overlay">
                            <div class="col">
                                <h2 class="m-0">{{$item->unit_remain}}</h2>{{$item->name}}
                            </div>
                            <div class="col">
                                <h2 class="m-0">&#8377 {{round($item->sales[$count]->total_amount)}}</h2>Total Sale
                            </div>
                            <div class="col">
                                <h2 class="m-0">{{$item->sales[$count]->total_qty}}</h2>Total Qty
                            </div>
                            <div class="col">
                                <h2 class="m-0">&#8377 {{round($item->sales[$count]->total_amount/$item->sales[$count]->total_qty)}}</h2>Avg Price
                            </div>
                        </div>
                        <div id="curve_chart" style="width: auto; height: 180px" class="card-img"></div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Date', 'Qty', 'Amount'],
        <?php
            for($i=0; $i<count($items[0]->sales); $i++){
                echo "['" . $items[0]->sales[$i]->bill_date . "'," . $items[0]->sales[$i]->total_qty . "," . $items[0]->sales[$i]->total_amount . "],";
            } 
        ?>
    ]);

    var options = {
        chartArea: { width: '100%', height: '90%'},
        // legend': {'position': 'bottom'}
        curveType: 'none',
        backgroundColor: { fill:'transparent' },
        vAxis: { gridlines: { color: 'transparent'} },
        animation: {
            duration: 2000,
            easing: 'out',
            startup: true
        },
    };

    var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

    chart.draw(data, options);
    }
</script>
@endsection
