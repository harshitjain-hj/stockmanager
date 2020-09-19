@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex align-items-center flex-column">
        @if(\Session::has('success'))
            <div class="alert alert-dismissible alert-success col-md-8 mb-1 p-2" style="margin: auto;" role="alert">
            {{\Session::get('success')}}
                <button type="button" class="close p-2" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="col-md-6">
            <!-- <div class="card"> -->
                <div class="card-header p-2">
                    <div class="row">
                        <div class="col">
                            <input type="text" id="item_initials" onkeyup="myFunction()" class="form-control" style="text-align: center;" placeholder="Customer Name" autofocus>
                        </div>
                        <!-- <div class="col-2 p-0">
                            <img onclick="myFunction()" src="{{ URL::asset('images/add.png')}}" style="width: 35px;">
                        </div> -->
                    </div>
                </div>
            <!-- </div> -->
        </div>

        <div class="m-1 pt-3 row row-cols-2 row-cols-md-4" id="listing">
            @foreach($customers as $customer)
                <div class="col px-2 mb-3 mx-auto customer">
                    <a class="btn p-0 m-0" href="{{ route('option', $customer['id']) }}">
                        <div class="card border-light h-100">
                            <img src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/e1773fc5-4926-4a6f-940c-25645a1b3320/dctlyf9-b37b4f5b-45f8-4690-a244-a9e09462917a.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOiIsImlzcyI6InVybjphcHA6Iiwib2JqIjpbW3sicGF0aCI6IlwvZlwvZTE3NzNmYzUtNDkyNi00YTZmLTk0MGMtMjU2NDVhMWIzMzIwXC9kY3RseWY5LWIzN2I0ZjViLTQ1ZjgtNDY5MC1hMjQ0LWE5ZTA5NDYyOTE3YS5wbmcifV1dLCJhdWQiOlsidXJuOnNlcnZpY2U6ZmlsZS5kb3dubG9hZCJdfQ.89AJtCEkFv-8Tqogf7vsFgxldxtEUSA7wlacyzDSm2I" class="card-img-top" alt="...">
                            <div class="card-body p-1 text-center">
                                <h5 class="card-title m-1">{{$customer->name}}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
	function myFunction() {
	    var input, filter, listing, item, a, i, txtValue;
	    input = document.getElementById("item_initials");
	    filter = input.value.toUpperCase();
	    listing = document.getElementById("listing");
        item = listing.getElementsByClassName("customer");
	    for (i = 0; i < item.length; i++) {
            // console.log(item[i].getElementsByTagName("h5"));
	        a = item[i].getElementsByTagName("h5")[0];
            txtValue = a.textContent || a.innerText;
	        if (txtValue.toUpperCase().indexOf(filter) > -1) {
	            item[i].style.display = "";
				console.log(txtValue.toUpperCase().indexOf(filter));
	        } else {
	            item[i].style.display = "none";
	        }
	    }
	}
</script>
@endsection
