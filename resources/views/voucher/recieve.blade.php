@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <form method="POST" action="{{ route('print.recieve', $customer->id) }}" onsubmit="add.disabled = true; return true;">
    @csrf
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
							<h6>
							@foreach(json_decode($customer->remain_assets, true) as $item)
								<?php $key = array_search($item['asset_id'], array_column(json_decode($items), 'id')); ?>
								<span id="actual_asset_remain_{{$item['asset_id']}}" style="display: none">{{$item['asset_remain']}}</span>
                            	{{ $items[$key]['name'] }} {{ $items[$key]['sku'] }}-<h4 id="asset_remain_{{$item['asset_id']}}">{{$item['asset_remain']}}</h4>
							@endforeach
							</h6>
                        </div>
                    </div>
                </div>
                <div class="col p-0 pt-2 m-0">
                    <div id="">
                        <div class="card p-1 card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img src="{{ URL::asset('images/rupee.png')}}" class="card-img" style="max-width: 65%;" align="right">
                                </div>
                                <div class="col-8 p-1 text-center" style="margin:auto;">
                                    <div class="px-1 form-inline d-flex justify-content-start">
                                        <p class="align-top m-0" style="height:40px">&#x20B9;</p>
                                        <input type="text" name="recieved_amount" style="height: 60px; width: 150px; font-size: 30pt; border-color: #ffffff00;" autocomplete="off" onkeyup="amount(this)" class="form-control p-0" inputmode="numeric" pattern="[0-9]*" placeholder="Amount">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-body mt-3 p-1">
                    <input type="text" name="remark" style="height: 30px; font-size: 15pt; border-color: #ffffff00;" autocomplete="off" class="form-control p-0" placeholder="Remark">
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
                                                        <input type="hidden" name="asset[{{$item->id}}][id]" value="{{$item->id}}">
                                                        <input type="hidden" name="asset[{{$item->id}}][name]" value="{{$item->name}} {{$item->sku}}">
                                                        <input type="hidden" name="asset[{{$item->id}}][sent]" value="{{NULL}}">
                                                        <input type="text" name="asset[{{$item->id}}][recieved]" style="height: 50px; width: 75px; font-size: 30pt; border-color: #ffffff00;" autocomplete="off" onkeyup="asset(this)" class="form-control p-0 {{$item->id}}" inputmode="numeric" pattern="[0-9]*" placeholder="Qty" autofocus>
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
            <input type="submit" id="submit-form" style="visibility: hidden;"/>
        </div>
    </form>
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
		var asset_id = element.className;
		var actual = document.getElementById('actual_asset_remain_'+asset_id.replace('form-control p-0 ','')).innerHTML
        document.getElementById('asset_remain_'+asset_id.replace('form-control p-0 ','')).innerHTML = actual - value;
    }
</script>

<script>
    document.getElementById("spcl-btn").innerHTML="Save & Print";
    document.getElementById("spcl-btn").style.visibility = "";
</script>

@endsection
