@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if(\Session::has('success'))
                <div class="alert alert-dismissible alert-success col-md-8 mb-1 p-2" style="margin: auto;" role="alert">
                {{\Session::get('success')}}
                    <button type="button" class="close p-2" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="row card-header d-flex justify-content-around">
                    <div class="row">
                        <div class="px-3"><h3 class="pt-1">Customers</h3></div>
                        <div class="px-3">
                            <a type="button" class="btn btn-secondary mr-3" href="{{ route('customer.create') }}">ADD</a>
                            <button type="button" class="btn btn-primary" onclick="exportTableToExcel('customer', 'customer')">Save</button>
                        </div>
                    </div>
                    <div class="input-group flex-nowrap pt-2 col-10">
						<input type="text" class="form-control form-control-sm" id="item_initials" placeholder="Enter Customer Name initials" onkeyup="myFunction()">
					</div>
                </div>

                <div class="card-body">
                    <?php $customers = json_decode( $customers, true ); ?>
                    @if(!empty($customers))
                        <table class="table table-hover table-sm table-responsive-sm" id="customer">
                            <thead>
                                <tr>
                                    @foreach($customers[0] as $key => $value)
                                        @if($key == 'id')

                                        @else
                                            <th scope="col" class="align-middle">{{ $key}}</th>
                                        @endif
                                    @endforeach
                                        <th scope="col">Edit</th>
                                </tr>
                            </thead>
                            <tbody id="listing">
                                @foreach($customers as $customer)
                                    <tr>
                                        @foreach($customer as $key => $value)
                                            @if($key == 'id')

                                            @else
                                                <td>{{$value}}</td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <a href="{{ route('customer.edit', $customer['id']) }}">
                                                <img src="{{ URL::asset('images/edit.png')}}" alt="Edit" style="height: 22px; width: 22px; display: block; margin: auto;">
                                            </a>
                                        </td>
                                            
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert text-white bg-dark text-center" role="alert">
                            No customer recorded.
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
