@extends('layouts.app')

@section('content')

<style>
.form-control {
    text-align: center;
}
.page {
  width: 56mm;
  height: 70mm;
  /* padding: 2mm; */
  margin: 1mm auto;
  /* border: 1px orange solid; */
  border-radius: 5px;
  background: #D3D3D3;
}

.subpage {
  padding: 5px;
  /* border: 1px red solid; */
}

@page {
  size: A5;
  margin: 0;
}

@media print {

  html,
  body {
    width: 56mm;
    height: 70mm;
    size: portrait;
    margin: 4mm 2mm 4mm 2mm;

  }
}

</style>

<div class="container-fluid">
    <form method="POST" action="{{ route('print.sale', $customer->id) }}" onsubmit="add.disabled = true; return true;">
    @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header p-2">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="m-0 text-center">{{$customer->name}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <table class="table table-bordered table-sm m-0 text-center lead">
                        <thead>
                            <tr>
                                <th scope="col">Item</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $amount = 0; 
                                $asset = 0;
                            ?>
                            @foreach($item_array as $item)
                                <tr>
                                    <td>{{explode('#', $item['info'])[1]}}</td>
                                    <td>{{$item['qty']}}</td>
                                    <td>&#x20B9; {{$item['rate']}}</td>
                                </tr>
                                <?php 
                                    $amount = $amount + ($item['rate'] * $item['qty']);
                                    $type = explode('#', $item['info'])[3];
                                    $asset = $asset + ($type * $item['qty']);
                                ?>
                            @endforeach
                                <tr>
                                    <th scope="row" colspan="2">Total Amount</td>
                                    <th scope="row">&#x20B9; {{$amount}}</td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="2">Total Asset</td>
                                    <th scope="row">{{$asset}}</td>
                                </tr>
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="item_list" value="{{json_encode($item_array)}}">
                <input type="hidden" name="total_amount" value="{{$amount}}">
                <div class="mb-2">
                    <div class="row">
                        <div class="col-md-6 mb-2 d-flex align-items-stretch">
                            <div class="card">
                                <div class="row" style="margin: auto;">
                                    <div class="col-4">
                                        <img src="{{ URL::asset('images/rupee.png')}}" class="card-img" style="max-width: 75%;" align="right">
                                    </div>
                                    <div class="col-8 text-center" style="margin:auto;">
                                        <div class="px-1 form-inline d-flex justify-content-start">
                                            <p class="align-top m-0" style="height:40px">&#x20B9;</p>
                                            <input type="text" name="amt_recieved" style="height: 60px; width: 147px; font-size: 29pt; border-color: #ffffff00;" autocomplete="off" class="form-control p-0" inputmode="numeric" pattern="[0-9]*" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="m-0 pt-0 row row-cols-2 row-cols-md-2">
                                @foreach($item_array as $item)
                                    @if(explode('#', $item['info'])[3])
                                        <div class="col px-0 px-md-1 mb-2">
                                            <div class="card mb-0">
                                                <button class="btn w-100 p-0" type="button" id="{{explode('#', $item['info'])[0]}}" aria-expanded="false" onclick="show_hide(this)">
                                                    <img src="{{ URL::asset('images/crate.png')}}" id="hide_{{explode('#', $item['info'])[0]}}" class="card-img" alt="...">
                                                    <div class="card-body p-1">
                                                        <h5 class="card-title m-0">{{explode('#', $item['info'])[1]}} {{explode('#', $item['info'])[2]}}</h5>
                                                    </div>
                                                </button>
                                                <div id="show_{{explode('#', $item['info'])[0]}}" style="display: none;" class="col p-0 mt-0">
                                                    <div class="card-body p-1">
                                                        <input type="hidden" name="asset[{{explode('#', $item['info'])[0]}}][id]" value="{{explode('#', $item['info'])[0]}}">
                                                        <input type="hidden" name="asset[{{explode('#', $item['info'])[0]}}][name]" value="{{explode('#', $item['info'])[1]}} {{explode('#', $item['info'])[2]}}">
                                                        <input type="hidden" name="asset[{{explode('#', $item['info'])[0]}}][sent]" value="{{$item['qty']}}">
                                                        <input type="text" name="asset[{{explode('#', $item['info'])[0]}}][recieved]" style="height: 30px; font-size: 24pt; border-color: #ffffff00;" autocomplete="off" class="form-control p-0 {{explode('#', $item['info'])[0]}}" inputmode="numeric" pattern="[0-9]*" placeholder="Recieved">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-body p-1">
                    <input type="text" name="remark" style="height: 30px; font-size: 15pt; border-color: #ffffff00;" autocomplete="off" class="form-control p-0" placeholder="Remark">
                </div>
            
            <!-- <div class="fixed-bottom m-4 d-flex justify-content-end">
                <button type="submit" name="add" class="btn btn-primary btn-lg">
                    <h2 class="m-0">Print</h2>
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

<script>
    document.getElementById("spcl-btn").innerHTML="Save & Print";
    document.getElementById("spcl-btn").style.visibility = "";
</script>
@endsection
