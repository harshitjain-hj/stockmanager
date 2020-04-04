@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="row p-2">
                <div class="col-sm-7 pb-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{$store->name}}</h3>
                            <h6 class="card-subtitle mb-2 text-muted">Mobile no, - {{$store->mobile_no}}</h6>
                            <hr>
                            <div class="row text-center">
                                <div class="col">
                                    Item - <span class="text-success font-weight-bold">{{$store->item_name}}</span> 
                                </div>
                                <div class="col">
                                    Stored Qty - <span class="text-success font-weight-bold">{{$store->qty}}</span> 
                                </div>
                                <div class="col">
                                    Remaining Qty - <span class="text-success font-weight-bold">{{$store->remain_qty}}
                                </div>
                            </div>
                            <hr>
                            <div class="row text-center">
                                <div class="col">
                                    Store rate - <span class="text-danger font-weight-bold">₹{{$store->monthly_amount}}</span> 
                                </div>
                                <div class="col">
                                    Storage date - <span class="text-danger font-weight-bold">{{date('d-m-Y', strtotime($store->storage_date))}}</span>
                                </div>
                                <div class="col">
                                    Payable amount - <span class="text-danger font-weight-bold">₹{{$store->payable_amount}}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row text-center">
                                <div class="col">
                                    Floor - <span class="text-primary font-weight-bold">{{$store->floor}}</span> 
                                </div>
                                <div class="col">
                                    Block - <span class="text-primary font-weight-bold">{{$store->block}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="row justify-content-center pb-4">
                        <a type="button" href="{{ route('store.edit', $store->id) }}" class="btn text-light btn-outline-light mx-2"><strong>- Withdraw</strong></a>
                        <button type="button" class="btn text-success btn-outline-success mx-2" onclick="exportTableToExcel('withdraw', '{{$store->item_name}}_{{$store->name}}')">Save</button>
                    </div>
                    <?php $withdraw_infos = json_decode( $withdraw_infos, true ); ?>
                    @if(!empty($withdraw_infos))
                        <table class="table table-borderless text-center bg-white table-sm" style="border-radius: 5px;" id="withdraw">
                            <thead>
                                <tr>
                                    @foreach($withdraw_infos[0] as $key => $value)
                                        @if($key == 'created_at' || $key == 'store_id' || $key == 'id')

                                        @else
                                            <th scope="col">{{ $key}}</th>
                                        @endif  
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdraw_infos as $withdraw_info)
                                    <tr>
                                        @foreach($withdraw_info as $key => $value)
                                            @if($key == 'created_at' || $key == 'store_id' || $key == 'id')

                                            @else
                                                <td>{{$value}}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert text-white bg-dark text-center" role="alert">
                            No withdraw since.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
