@extends('layouts.app')

@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    
    google.charts.load('current', {'packages':['corechart']});
    // passedArray
    function drawChart(passedArray, chart_id) {
        // console.log(chart_id);
        var data = google.visualization.arrayToDataTable(passedArray);

        var options = {
            chartArea: { width: '100%', height: '90%'},
            curveType: 'none',
            backgroundColor: { fill:'transparent' },
            vAxis: { gridlines: { color: 'transparent'} },
            animation: {
                duration: 2000,
                easing: 'out',
                startup: true
        },
    };

    var chart = new google.visualization.LineChart(document.getElementById(chart_id));

    chart.draw(data, options);
    }
</script>

<?php
    $chart_array = [];
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><p class="m-0">Today Date - {{ date('j F Y \, l') }}</p></div>

                <div class="card-body p-0">
                @if(!empty($items))
                    <!-- if there is any item to show -->
                    @foreach($items as $item)
                        <!-- iterating through items -->
                        <?php $count = count($item->sales) - 1;?>
                        <div class="container card bg-dark text-white text-center mb-1">
                            <!-- item info -->
                            <div class="row row-cols-2 row-cols-md-4 pt-3 card-img-overlay">
                                <div class="col">
                                    <h2 class="m-0">{{$item->unit_remain}}</h2><h5>{{$item->name}}</h5>
                                </div>
                                <div class="col">
                                    <h2 class="m-0">&#8377 {{round($item->sales[$count]->total_amount)}}</h2>Total Sale
                                </div>
                                <div class="col">
                                    <h2 class="m-0">{{$item->sales[$count]->total_qty}}</h2>Total Qty
                                </div>
                                <div class="col">
                                    <h2 class="m-0">&#8377 {{round( $item->sales[$count]->total_amount / max($item->sales[$count]->total_qty, 1) )}}</h2>Avg Price
                                </div>
                            </div>
                            <!-- creating array for plotting chart using javascript -->
                            <?php
                                $array = $item->sales;
                                $record = [['Date', 'Qty', 'Amount']];
                                foreach($array as $sale){
                                    $date = array();
                                    array_push($date, $sale->bill_date);
                                    array_push($date, (int)$sale->total_qty);
                                    array_push($date, (int)$sale->total_amount);
                                    array_push($record, $date);
                                }
                                $chart_array[$item->item_id] = $record;
                            ?>
                            <!-- container for chart -->
                            <div id="chart_{{$item->item_id}}" style="width: auto; height: 180px" class="card-img"></div>
                        </div>
                        
                    @endforeach
                @else
                    <div class="alert bg-dark text-white text-center" role="alert">
                        Nothing to show!!
                    </div>
                @endif    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var obj = <?php echo json_encode($chart_array); ?>;
        google.charts.setOnLoadCallback(function () {
            for(var index in obj) {
                drawChart(obj[index], 'chart_' + index);
            }
        });
</script>


@endsection
