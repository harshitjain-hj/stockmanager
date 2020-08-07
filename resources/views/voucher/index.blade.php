@extends('layouts.app')

@section('content')
<?php $sales = json_decode( $sales, true ); ?>
<?php $recievings = json_decode( $recievings, true ); ?>
<?php $unverified = json_decode( $unverified, true ); ?>

<div class="container bills">
    <div class="row justify-content-center">
		<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
		  <li class="nav-item">
		    <a class="nav-link active" id="pills-sale-tab" data-toggle="pill" href="#pills-sale" role="tab" aria-controls="pills-sale" aria-selected="true">Sale</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="pills-recieve-tab" data-toggle="pill" href="#pills-recieve" role="tab" aria-controls="pills-recieve" aria-selected="false">Recieve</a>
		  </li>
		  <li class="nav-item">
		    <a class="nav-link" id="pills-unverified-tab" data-toggle="pill" href="#pills-unverified" role="tab" aria-controls="pills-unverified" aria-selected="false">Unverified</a>
		  </li>
		</ul>
    </div>
	<div class="row justify-content-center">
		<div class="col-md-7">
			<div class="tab-content card" id="pills-tabContent">
			  <!-- Sales tab -->
			  <div class="tab-pane fade show active" id="pills-sale" role="tabpanel" aria-labelledby="pills-sale-tab">
				  	@if($sales)
						<table class="table table-hover table-sm text-center table-responsive">
					  <thead>
					    <tr style="text-transform:capitalize;">
							@foreach($sales[0] as $key => $value)
  								<th scope="col" class="align-middle">{{ $key }}</th>
  						  	@endforeach
					    </tr>
					  </thead>
					  <tbody>
						  @foreach($sales as $sale)
							  <tr>
								  @foreach($sale as $key =>$value)
								  		@if($key == 'item')
											<?php $items = json_decode($value, true); ?>
											<td>
												@foreach($items as $item)
													{{explode('#', $item['info'])[1]}}<br/>
												@endforeach
											</td>
										@elseif($key == 'total')
											<td>
												<div class="mb-0" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													@foreach(json_decode($sale['item'], true) as $item)
														{{$item['qty']}}x&#8377;{{$item['rate']}}<br/>
													@endforeach
												<hr class="my-0">
												{{$value}}
												</div>
												<div class="dropdown-menu py-0" aria-labelledby="dropdownMenu2">
												    <table class="table table-sm text-center table-borderless mb-0">
												    	<tbody>
															@foreach(json_decode($sale['item'], true) as $item)
																<tr>
																	<td>{{explode('#', $item['info'])[1]}}</td>
																	<td>{{$item['qty']}}</td>
																	<td>&#8377;{{$item['rate']}}</td>
																</tr>
															@endforeach
												    	</tbody>
												    </table>
												</div>
											</td>
										@elseif($key == 'asset')
											<?php $items = json_decode($value, true); ?>
											<td>
											@foreach($items as $item)
												<span class="text-success">+{{$item['sent']}}</span><span class="text-danger"><?php echo ($item['recieved']) ? '-' : '' ; ?>{{$item['recieved']}}</span><br/>
											@endforeach
											</td>
										@else
											<td>{{$value}}</td>
										@endif
								  @endforeach
							  </tr>
						  @endforeach
					  </tbody>
					</table>
					@else
						<div class="alert alert-primary m-0" role="alert">
							Nothing to show yet!!
						</div>
					@endif
			  </div>

			  <!-- Recievings tab -->
			  <div class="tab-pane fade" id="pills-recieve" role="tabpanel" aria-labelledby="pills-recieve-tab">
				  @if($recievings)
				  	<table class="table table-hover table-sm text-center table-responsive">
					  <thead>
					    <tr style="text-transform:capitalize;">
							@foreach($recievings[0] as $key => $value)
  								<th scope="col" class="align-middle">{{ $key }}</th>
  						  	@endforeach
					    </tr>
					  </thead>
					  <tbody>
						  @foreach($recievings as $recieving)
							  <tr>
								  @foreach($recieving as $key =>$value)
								  		@if($key == 'asset')
											<?php $items = json_decode($value, true); ?>
											<td>
												@foreach($items as $item)
													<span class="text-danger"><?php echo ($item['recieved']) ? '-' : '' ; ?>{{$item['recieved']}}</span><br/>
												@endforeach
											</td>
										@else
											<td>{{$value}}</td>
										@endif
								  @endforeach
							  </tr>
						  @endforeach
					  </tbody>
					</table>
				  @else
					  <div class="alert alert-primary m-0" role="alert">
						  Nothing to show yet!!
					  </div>
				  @endif
			  </div>

			  <!-- Unverified -->
			  <div class="tab-pane card fade" id="pills-unverified" role="tabpanel" aria-labelledby="pills-unverified-tab">
					@if($unverified)
  					  <table class="table table-hover table-sm text-center table-responsive">
	  					<thead>
	  					  <tr style="text-transform:capitalize;">
	  						  @foreach($unverified[0] as $key => $value)
							  		@if($key == 'voucher_type')

									@else
	  							 		<th scope="col" class="align-middle">{{ $key }}</th>
									@endif
	  						  @endforeach
	  					  </tr>
	  					</thead>
	  					<tbody>
	  						@foreach($unverified as $sale)
								<tr data-toggle="modal" data-target="#sale{{$sale['V.ID']}}">
	  								@foreach($sale as $key =>$value)
	  									  @if($key == 'item' && !empty($value))
	  										  <?php $items = json_decode($value, true); ?>
	  										  <td>
	  											  @foreach($items as $item)
	  												  {{explode('#', $item['info'])[1]}}<br/>
	  											  @endforeach
	  										  </td>
										  @elseif($key == 'voucher_type')

	  									  @elseif($key == 'total' && !empty($sale['item']))
	  										  <td>
	  											  <div class="mb-0" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	  												  @foreach(json_decode($sale['item'], true) as $item)
	  													  {{$item['qty']}}x&#8377;{{$item['rate']}}<br/>
	  												  @endforeach
	  											  <hr class="my-0">
	  											  {{$value}}
	  											  </div>
	  											  <div class="dropdown-menu py-0" aria-labelledby="dropdownMenu2">
	  												  <table class="table table-sm text-center table-borderless mb-0">
	  													  <tbody>
	  														  @foreach(json_decode($sale['item'], true) as $item)
	  															  <tr>
	  																  <td>{{explode('#', $item['info'])[1]}}</td>
	  																  <td>{{$item['qty']}}</td>
	  																  <td>&#8377;{{$item['rate']}}</td>
	  															  </tr>
	  														  @endforeach
	  													  </tbody>
	  												  </table>
	  											  </div>
	  										  </td>
	  									  @elseif($key == 'asset')
	  										  <?php $items = json_decode($value, true); ?>
	  										  <td>
	  										  @foreach($items as $item)
	  											  <span class="text-success"><?php echo ($item['sent']) ? '+'.$item['sent'] : '' ; ?></span><span class="text-danger"><?php echo ($item['recieved']) ? '-'.$item['recieved'] : '' ; ?></span><br/>
	  										  @endforeach
	  										  </td>
	  									  @else
	  										  <td>{{$value}}</td>
	  									  @endif
	  								@endforeach
	  							</tr>
							@endforeach
	  					</tbody>
	  				  </table>
  				  	@else
  						<div class="alert alert-primary m-0" role="alert">
  						 	Nothing to show yet!!
  						</div>
  				  	@endif
			  </div>
			</div>
		</div>
    </div>
</div>
<!-- all the modals -->
@foreach($unverified as $sale)
	<div class="modal fade" id="sale{{$sale['V.ID']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenterTitle">{{$sale['name']}}</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <form method="POST" action="{{ route('verified', $sale['V.ID']) }}">
			  @csrf
			  <div class="modal-body">
				  <center>This is</center>
				  <div class="row justify-content-center">
					<div class="col text-right">
						<span class="form-control-lg align-self-center">Bill No :</span>
					</div>
					<div class="col text-left">
						<input type="text" style="width:60px;" name="bill_no" class="form-control form-control-lg px-1" value="<?php echo ($sale['voucher_type'] == 'Sale') ? $bill_no[0] : $bill_no[1];?>">
					</div>
				  </div>
			  </div>
			  <div class="modal-footer d-flex justify-content-around">
				  <!-- <form action="{{ route('rejected', $sale['V.ID']) }}" method="post"><button type="submit" class="btn btn-danger">Reject</button></form> -->
				  <!-- <button type="button" class="btn btn-warning">Edit</button> -->
				  <button type="submit" class="btn btn-success">Save to sale</button>
			  </div>
		  </form>
		</div>
	  </div>
	</div>
@endforeach
@endsection
