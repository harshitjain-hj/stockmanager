<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        body {
            background-color: #343a40;
            line-height: 1;
            /* font-weight: bold; */
        }
        @media print
        {
            @page
            {
                size: auto;   /*auto is the initial value  */
                /* this affects the margin in the printer settings */
                margin: auto;
                /* size: 58mm 103mm; */
            }
            html, body {
                /* width: 158mm; */
                /* font-size: 12px; */
                /* font-weight: 700; */
                /* border: 1px solid black; */

            }
            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
            #invoice-POS {
                margin: 0 !important;
            }
        }
    </style>
</head>
<body>
    <?php $voucher['asset_data'] = json_decode($voucher['asset_data']);?>
    <div id="invoice-POS" style="box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); width: 58mm; background: #FFF; margin: auto; margin-top: 25px;">
        <p class="my-0">&nbsp;</p>
        <center>
            <div class="font-weight-bolder">UNIC SALES</div>
        </center>
        <div class="row d-flex justify-content-around">
            <div class="col-3">#{{$voucher['id']}}</div>
            <div class="col-9 text-right">{{date('d-M | H:i', strtotime($voucher['created_at']))}}</div>
        </div>
        <center class="font-weight-bolder">{{$customer['name']}}</center>
		<center>
            <div>Till - {{date('d-M | H:i', strtotime($outstanding['updated_at']))}}</div>
        </center>
		<div class="row d-flex justify-content-around text-center">
            <div class="col-6">&#x20B9;{{$outstanding['remain_assets'][0]->asset_remain}}</div>
            <div class="col-6">{{$outstanding['remain_amount']}}</div>
        </div>
        @if($voucher['asset_data'] || $voucher['amount_recieved'])
            @if($voucher['asset_data'][0]->recieved !== NULL || $voucher['amount_recieved'])
                <center class="font-weight-bold">Receiving</center>
                <p class="my-0" style="height: 16px;">&nbsp;</p>
            @endif
            <table class="table table-borderless table-sm m-0">
                @if($voucher['asset_data'][0]->recieved !== NULL)
                    <thead>
                        <tr>
                            <th scope="col" class="py-0">ITEM(S)</th>
                            <th scope="col" class="text-right py-0">QTY</th>
                        </tr>
                    </thead>
                @endif
                <tbody>
                    @foreach($voucher['asset_data'] as $item)
                        @if($item->recieved !== NULL)
                            <tr>
                                <td class="py-0">{{$item->name}}</td>
                                <td class="text-right py-0">{{$item->recieved}}</td>
                            </tr>
                        @endif
                    @endforeach
                    @if($voucher['amount_recieved'] !== NULL)
                        <tr>
                            <th scope="row" class="py-0">Amt. Recieved</td>
                            <th scope="row" class="text-right py-0">&#x20B9; {{$voucher['amount_recieved']}}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif
        @if($voucher['remark'])
            <center class="font-weight-bold">Remark : {{$voucher['remark']}}</center>
        @endif
        <p class="my-0">&nbsp;</p>
        <center class="font-weight-bolder">------------------------------</center>
        <center>
            <div class="font-weight-bolder">UNIC SALES</div>
        </center>
        <div class="row d-flex justify-content-around">
            <div class="col-3">#{{$voucher['id']}}</div>
            <div class="col-9 text-right">{{date('d-M | H:i', strtotime($voucher['created_at']))}}</div>
        </div>
        <center class="font-weight-bolder">{{$customer['name']}}</center>
		<center>
            <div>Till - {{date('d-M | H:i', strtotime($outstanding['updated_at']))}}</div>
        </center>
		<div class="row d-flex justify-content-around text-center">
            <div class="col-6">&#x20B9;{{$outstanding['remain_assets'][0]->asset_remain}}</div>
            <div class="col-6">{{$outstanding['remain_amount']}}</div>
        </div>
        @if($voucher['asset_data'] || $voucher['amount_recieved'])
            @if($voucher['asset_data'][0]->recieved !== NULL || $voucher['amount_recieved'])
                <center class="font-weight-bold">Receiving</center>
                <p class="my-0" style="height: 16px;">&nbsp;</p>
            @endif
            <table class="table table-borderless table-sm m-0">
                @if($voucher['asset_data'][0]->recieved !== NULL)
                    <thead>
                        <tr>
                            <th scope="col" class="py-0">ITEM(S)</th>
                            <th scope="col" class="text-right py-0">QTY</th>
                        </tr>
                    </thead>
                @endif
                <tbody>
                    @foreach($voucher['asset_data'] as $item)
                        @if($item->recieved !== NULL)
                            <tr>
                                <td class="py-0">{{$item->name}}</td>
                                <td class="text-right py-0">{{$item->recieved}}</td>
                            </tr>
                        @endif
                    @endforeach
                    @if($voucher['amount_recieved'] !== NULL)
                        <tr>
                            <th scope="row" class="py-0">Amt. Recieved</td>
                            <th scope="row" class="text-right py-0">&#x20B9; {{$voucher['amount_recieved']}}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif
        @if($voucher['remark'])
            <center class="font-weight-bold">Remark : {{$voucher['remark']}}</center>
        @endif
        <p class="my-0">&nbsp;</p>
    </div>

    <!-- <div class="d-flex hidden-print justify-content-center fixed-bottom mx-3 py-3">
        <a href="{{ route('customerlist') }}" class="btn mx-4 btn-danger ">HOME</a>
        <button id="btnPrint" class="btn mx-4 btn-warning">Print</button>
    </div> -->
    <div class="container hidden-print d-flex my-4 fixed-bottom justify-content-center">
        <div class="col-md-4 d-flex justify-content-around align-self-center">
            <a href="{{ route('customerlist') }}" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure?')">HOME</a>
            <button id="btnPrint" class="btn btn-warning btn-lg">Print</button>
        </div>
    </div>
</body>
<script>
    if(window.print) {
        window.print();
    }
    const $btnPrint = document.querySelector("#btnPrint");
    $btnPrint.addEventListener("click", () => {
        window.print();
    });
</script>
</html>
