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
	<?php $total_amount = 0; ?>
    <div id="invoice-POS" style="box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); width: 60mm; background: #FFF; margin: auto; margin-top: 25px;">
		@if($summary)
			<table class="table text-center table-borderless table-sm m-0">
				<tbody>
					<tr>
						<td colspan="3" class="font-weight-bolder py-0">{{date('d-M | H:i')}}</td>
					</tr>
					@foreach($summary as $customer)
						<tr>
							<td colspan="3" class="text-left font-weight-bolder py-0">{{$customer['customer_name']}}</td>
						</tr>
						<tr>
							<td class="py-0">Out</td>
							<td class="py-0">&#8377; {{$customer['total_amount']}}</td>
							<td class="py-0">
								@if($customer['asset_data'])
									@foreach($customer['asset_data'] as $item)
										{{$item['name']}} : {{$item['sent']}}</br>
									@endforeach
								@else
									-
								@endif
							</td>
						</tr>
						<tr>
							<td class="py-0">In</td>
							<td class="py-0">&#8377; {{$customer['recieved_amount']}}</td>
							<td class="py-0">
								@if($customer['asset_data'])
									@foreach($customer['asset_data'] as $item)
										{{$item['name']}} : {{$item['recieved']}}</br>
									@endforeach
								@else
									-
								@endif
							</td>
							<?php $total_amount = $total_amount + $customer['recieved_amount']; ?>
						</tr>
					@endforeach
						<tr>
							<td colspan="2" class="font-weight-bolder py-0">Ttl amt.</td>
							<td colspan="1" class="font-weight-bolder py-0">&#8377; {{$total_amount}}</td>
						</tr>
				</tbody>
			</table>
		@else
			<div class="alert bg-light text-dark text-center p-1 m-0" role="alert">
				<strong>Nothing to print!!</strong>
			</div>
		@endif
    </div>
    <div class="container hidden-print d-flex my-4 fixed-bottom justify-content-center">
        <div class="col-md-4 d-flex justify-content-around align-self-center">
            <a href="{{ route('customerlist') }}" class="btn btn-danger btn-lg">Home</a>
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
