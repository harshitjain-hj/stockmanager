@extends('layouts.app')

@section('content')
<?php $repos = json_decode( $repos, true ); ?>
<?php $customers = json_decode( $customers, true ); ?>
<?php $items = json_decode( $items, true ); ?>
<!-- Variables -->
<?php
    $total_amount = 0;
    $remain_amount = 0;
	$remain_assets = 0;

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header justify-content-around row no-gutters">
                        <div class="col-sm-7 text-center">
							<h4 class="pt-1">Customer's Report</h4>
						</div>
                        <div class="input-group col-sm-5">
    						<input type="text" class="form-control" id="item_initials" placeholder="Enter Customer Name initials" onkeyup="myFunction()">
                            <button type="button" class="btn btn-primary ml-2" onclick="exportTableToExcel('report', 'report')">Save</button>
						</div>
                </div>

                <div class="card-body pt-0">
                <ul class="nav justify-content-center">
                    @foreach($items as $item)
                        <li class="nav-item">
                            <a class="nav-link active" href="repo?item={{$item['id']}}">{{$item['name']}}</a>
                        </li>
                    @endforeach
                </ul>
                    @if(!empty($repos))
                        <table class="table table-hover table-sm table-responsive-md" id="report">
                            <thead>
                                <tr>
                                    @foreach($repos[0] as $key => $value)
                                        @if($key == 'created_at' || $key == 'updated_at' || $key == 'id' || $key == 'name')

                                        @elseif ($key == 'customer_id')
                                            <th scope="col" class="align-middle">Customer Name</th>
                                        @elseif ($key == 'item_id')
                                            <th scope="col" class="align-middle">Item Name</th>        
                                        @else
                                            <th scope="col" class="align-middle">{{ $key}}</th>
                                        @endif  
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody id="listing">
                                @foreach($repos as $repo)
                                    <tr onclick="window.location='/repo/{{$repo['id']}}'">
                                        @foreach($repo as $key => $value)
                                            @if($key == 'created_at' || $key == 'updated_at' || $key == 'id' || $key == 'name')

                                            @elseif ($key == 'customer_id')
                                                <td>{{$repo['name']}}</td>
                                            @elseif ($key == 'item_id')
                                                <?php 
                                                    $key = array_search($value, array_column($items, 'id'));
                                                    $name = $items[$key]['name'];
                                                    $sku = $items[$key]['sku'];
                                                    // dd($name);
                                                ?>
                                                <td>{{$name}} | {{$sku}}</td>
                                            @else
                                                <td>{{$value}}</td>
                                            @endif
                                        @endforeach
                                        <?php if($repo['remain_amount'] >= 0 ) $remain_amount = $remain_amount + $repo['remain_amount']; ?>
                                        <?php if($repo['remain_assets'] >= 0 ) $remain_assets = $remain_assets + $repo['remain_assets']; ?>
                                    </tr>
                                @endforeach
                                <tr class="table-dark text-body">
                                    <td>&nbsp</td>
                                    <td colspan=2 class="text-center">Total</td>
                                    <td>{{$remain_amount}}</td>
                                    <td>{{$remain_assets}}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <div class="alert text-white bg-dark text-center" role="alert">
                            No bill added since.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	function myFunction() {
	    var input, filter, listing, item, a, i, txtValue;
	    input = document.getElementById("item_initials");
	    filter = input.value.toUpperCase();
	    listing = document.getElementById("listing");
	    item = listing.getElementsByTagName("tr");
	    for (i = 0; i < item.length; i++) {
	        a = item[i].getElementsByTagName("td")[0];
	        txtValue = a.textContent || a.innerText;
	        if (txtValue.toUpperCase().indexOf(filter) > -1) {
	            item[i].style.display = "";
	        } else {
	            item[i].style.display = "none";
	        }
	    }
	}
</script>
@endsection
