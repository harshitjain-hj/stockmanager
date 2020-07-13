@extends('layouts.app')

@section('content')
<script>
    function printDiv(divId) {
        window.frames["print_frame"].document.body.innerHTML = document.getElementById(divId).innerHTML;
        window.frames["print_frame"].window.focus();
        window.frames["print_frame"].window.print();
    }
</script>

<div class="container-fluid">
    <div class="row justify-content-center">   
            <div id="bill">             
                <div id="invoice-POS" class="text-monospace" style="box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); padding:2mm; margin: 0 0; width: 70mm; background: #FFF;">
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
                    <center>
                    <div> 
                        <h3 class="mb-1">Unic Sales</h3>
                    </div>
                    </center>
                    <div class="row d-flex justify-content-around">
                        <div class="col-3">#1039</div>
                        <div class="col-9 text-right">{{date('d-M | H:i')}}</div>
                    </div>
                    <center><h5><strong>{{$customer['name']}}</strong></h5></center>
                    <hr class="my-1"/>
                    <center>Sale</center>
                    <?php $data['item_data'] = json_decode($data['item_data']);?>
                    <?php $data['asset_data'] = json_decode($data['asset_data']);?>
                    <?php 
                        $amount = 0; 
                        $asset = 0;
                    ?>
                    <table class="table table-borderless table-sm m-0">
                        <thead>
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Qty</th>
                                <th scope="col"class="text-right">Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['item_data'] as $item)
                            <tr>
                                <td>{{explode('#', $item->info)[1]}}</td>
                                <td>{{$item->qty}}</td>
                                <td class="text-right">{{$item->rate}}</td>
                            </tr>
                            <?php 
                                $amount = $amount + ($item->rate * $item->qty);
                                $type = explode('#', $item->info)[3];
                                $asset = $asset + ($type * $item->qty);
                            ?>
                            @endforeach
                            <tr>
                                <th scope="row">Total Amt.</td>
                                <th scope="row" class="text-right" colspan="2">&#x20B9; {{$amount}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Total Asset</td>
                                <th scope="row" class="text-right" colspan="2">{{$asset}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if($data['asset_data'])
                        <hr class="my-1"/>
                        <center>Receiving</center>
                        <table class="table table-borderless table-sm m-0">
                            <thead>
                                <tr>
                                    <th scope="col">Item(s)</th>
                                    <th scope="col" class="text-right">Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data['asset_data'] as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td class="text-right">{{$item->recieved}}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th scope="row">Amt. Recieved</td>
                                    <th scope="row" class="text-right">&#x20B9; {{$data['amount_recieved']}}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        <a href="javascript:printDiv('bill')">Print</a><br>
    <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
    </div>
</div>
@endsection
