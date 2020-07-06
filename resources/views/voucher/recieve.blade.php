@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card mb-2">
                <div class="card-header p-2">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="m-0 text-center">{{$customer->name}}</h4>
                        </div>
                    </div>
                </div>
                <div class="row card-body p-2 text-center">
                    <div class="col">
                        <p class="m-0">Pending Amount</p>
                        <h4 id="amt_remain">{{$customer->remain_amount}}</h4>
                    </div>
                    <div class="col">
                        <p class="m-0">Pending Asset</p>
                        <h4 id="asset_remain">{{$customer->remain_assets}}</h4>
                    </div>
                </div>
            </div>
            <div class="col p-0 pt-2 m-0">
                <div id="">
                    <div class="card p-1 card-body">
                        <div class="row">
                            <div class="col-4">
                                <img src="{{ URL::asset('images/rupee.png')}}" class="card-img" style="max-width: 75%;" align="right">
                            </div>
                            <div class="col-8 p-1 text-center" style="margin:auto;">
                                <div class="px-1 form-inline d-flex justify-content-start">
                                    <p class="align-top m-0" style="height:40px">&#x20B9;</p>
                                    <input type="text" name="rate" style="height: 60px; width: 150px; font-size: 30pt; border-color: #ffffff00;" autocomplete="off" onkeyup="amount(this)" class="form-control p-0" inputmode="numeric" pattern="[0-9]*" placeholder="Amount">
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="m-0 pt-3 row row-cols-1 row-cols-md-3">
                @foreach($items as $item)
                    <div class="col px-0 mb-2">
                        <div class="card">
                            <button class="btn w-100 p-0" type="button" id="{{$item->id}}" aria-expanded="false" onclick="show_hide(this)">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTQoMrNg8J41yewjs7eW6lI-ksImInG6QZl5w&usqp=CAU" id="hide_{{$item->id}}" class="card-img">
                                <div class="card-body p-2">
                                    <h5 class="card-title m-0">{{$item->name}} {{$item->sku}}</h5>
                                </div>
                            </button>
                            <div class="col p-0 mt-0">
                                <div id="show_{{$item->id}}" style="display: none;">
                                    <div class="card p-1 card-body">
                                        <div class="row">
                                            <div class="col">
                                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTQoMrNg8J41yewjs7eW6lI-ksImInG6QZl5w&usqp=CAU" id="hide_{{$item->id}}" class="card-img">
                                            </div>
                                            <div class="col text-center" style="margin:auto;">
                                                <div class="px-1 form-inline d-flex justify-content-between">
                                                    <input type="text" name="qty" style="height: 50px; width: 75px; font-size: 30pt; border-color: #ffffff00;" autocomplete="off" onkeyup="asset(this)" class="form-control p-0 {{$item->id}}" inputmode="numeric" pattern="[0-9]*" placeholder="Qty" autofocus>
                                                    <p class="align-bottom m-0" style="height: 0px;">{{$item->sku}}(s)</p>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function show_hide(element) {        
        var x = document.getElementById("hide_"+element.id);
        var y = document.getElementById("show_"+element.id);
        if (x.style.display === "none") {
            x.style.display = "block";
            y.style.display = "none";
        } else {
            x.style.display = "none";
            y.style.display = "block";
            document.getElementsByClassName(element.id)[0].focus();
        }        
        $('html,body').animate({
        scrollTop: $("#"+element.id).offset().top - 60},
        'slow');
    }
</script>

<script type="text/javascript">
    function amount(element) {
        var value = element.value;        
        document.getElementById('amt_remain').innerHTML = {{$customer->remain_amount}} - value;
    }
</script>

<script type="text/javascript">
    function asset(element) {
        var value = element.value;        
        document.getElementById('asset_remain').innerHTML = {{$customer->remain_assets}} - value;
    }
</script>

<script>
    document.getElementById("spcl-btn").innerHTML="Save & Print";
    document.getElementById("spcl-btn").style.visibility = "";
</script>

@endsection