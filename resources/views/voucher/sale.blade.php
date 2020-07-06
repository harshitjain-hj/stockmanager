@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <form method="POST" action="{{ route('generate.sale', $customer->id) }}" onsubmit="add.disabled = true; return true;">
    @csrf
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="m-0 text-center">{{$customer->name}}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m-0 pt-3 row row-cols-1 row-cols-md-3">
                @foreach($items as $item)
                    <div class="col px-1 mb-3">
                        <div class="card">
                            <button class="btn w-100 p-0" type="button" id="{{$item->id}}" aria-expanded="false" onclick="show_hide(this)">
                                <img src="https://cdn3.iconfinder.com/data/icons/illustrated-vector-fruit-pack/600/banana_Icon-512.png" id="hide_{{$item->id}}" class="card-img" alt="...">
                                <div class="card-body p-2">
                                    <h5 class="card-title m-0">{{$item->name}}</h5>
                                </div>
                            </button>
                            <div class="col p-0 mt-0">
                                <div id="show_{{$item->id}}" style="display: none;">
                                    <div class="card p-1 card-body">
                                        <div class="form-inline d-flex">
                                        <input type="hidden" name="{{$item->id}}[info]" value="{{$item->id}}#{{$item->name}}#{{$item->sku}}#{{$item->asset}}">
                                            <div class="col-6 px-1 form-inline d-flex justify-content-center">
                                                <input type="text" name="{{$item->id}}[qty]" style="height: 60px; width: 75px; font-size: 30pt; border-color: #ffffff00;" autocomplete="off" onkeyup="multiply(this)" class="form-control p-0 {{$item->id}}" inputmode="numeric" pattern="[0-9]*" placeholder="Qty" autofocus>
                                                <p class="align-bottom m-0" style="height: 0px;">{{$item->sku}}(s)</p>
                                            </div>
                                            <div class="col-6 px-1 form-inline d-flex justify-content-center">
                                                <p class="align-top m-0" style="height:40px">&#x20B9;</p>
                                                <input type="text" name="{{$item->id}}[rate]" style="height: 60px; width: 103px; font-size: 30pt; border-color: #ffffff00;" autocomplete="off" onkeyup="multiply(this)" class="form-control p-0 {{$item->id}}" inputmode="numeric" pattern="[0-9]*" placeholder="Rate">
                                                <p class="align-bottom m-0" style="height: 0px;">/{{$item->sku}}</p>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="d-flex justify-content-center">
                                            <h3 class="text-dark">Total :</h3>
                                            <h3 id="result_0{{$item->id}}">0</h3>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- <div class="fixed-bottom m-4 d-flex justify-content-end">
                <button type="submit" name="add" class="btn btn-primary btn-lg">
                    <h2 class="m-0">Checkout</h2>
                </button> -->
                <input type="submit" id="submit-form" style="visibility: hidden;"/>
            <!-- </div> -->
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
    function multiply(element) {
        var values = document.getElementsByClassName(element.className);        
        var result = values[0].value * values[1].value;
        document.getElementById("result_"+element.className.match(/\d/g).join("")).innerHTML = result;
    }
</script>

<script>
    document.getElementById("spcl-btn").innerHTML="Checkout";
    document.getElementById("spcl-btn").style.visibility = "";
</script>

@endsection
