@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            
            <div class="row p-2">
                <div class="col-sm-7 pb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="card-title">{{$store->name}}</h3>
                                    <h6 class="card-subtitle mb-2 text-muted">Mobile no, - {{$store->mobile_no}}</h6>
                                </div>
                                <div class="col text-center">
                                    <a type="button" href="{{ route('store.create_more', $store->store_id) }}" class="btn text-dark btn-outline-dark mx-2">Add more</a> 
                                </div>
                            </div>

                            <hr>
                            <div class="row text-center">
                                <div class="col">
                                    Item - <span class="text-success font-weight-bold">{{$store->item_name}}</span> 
                                </div>
                                <div class="col">
                                    Stored Qty - <span class="text-success font-weight-bold">{{$store->stored_qty}}</span> 
                                </div>
                                <div class="col">
                                    Remaining Qty - <span class="text-success font-weight-bold">{{$store->remain_qty}}
                                </div>
                            </div>
                            <hr>
                                    
                            <table class="table table-borderless table-hover table-sm text-center">
                                <thead>
                                    <tr>
                                        <!-- <th scope="col">#</th> -->
                                        <th scope="col">Remain qty</th>
                                        <th scope="col" class="align-middle">Location</th>
                                        <th scope="col">Payable Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($store_info as $info)
                                        <tr>
                                            <!-- <th scope="row">1</th> -->
                                            <td>{{$info['remain_qty']}}</td>
                                            <td>{{$info['floor']}} | {{$info['block']}}</td>
                                            <td>&#8377;{{$info['payable_amount']}}</td>
                                            <td><a href="#" class="text-decoration-none">{{$info['status']}}</a></td>
                                            <td>
                                                <span class="badge badge-pill badge-secondary" data-toggle="collapse" data-target="#row_{{$info['id']}}" aria-expanded="false" aria-controls="row_{{$info['id']}}">
                                                    &#709
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                            <div class="collapse" id="row_{{$info['id']}}">
                                                <div class="card card-body p-1">
                                                    <ul class="list-inline mb-1">
                                                        <li class="list-inline-item"><strong>Stored qty: </strong>{{$info['qty']}}</li>
                                                        <li class="list-inline-item"><strong>Storage date: </strong>{{$info['storage_date']}}</li>
                                                        <li class="list-inline-item"><strong>APU: </strong>&#8377;{{$info['monthly_amount']}}</li>
                                                        <li class="list-inline-item"><strong>Lorry_no: </strong>{{$info['lorry_no']}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="row justify-content-center pb-4">
                        <select onchange="if (this.value) window.location.href='withdraw/'+ this.value" class="custom-select" style="width: auto;">
                                <option selected >Withdraw</option>
                            @foreach($store_info as $info)
                                <option value="{{$info['id']}}">{{$info['floor']}} | {{$info['block']}} </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn text-success btn-outline-success mx-2" onclick="exportTableToExcel('withdraw', '{{$store->item_name}}_{{$store->name}}')">Save</button>
                    </div>
                    
                    <?php $withdraw_infos = json_decode( $withdraw_infos, true ); ?>
                    @if(!empty($withdraw_infos))
                        <table class="table-borderless text-center bg-white bg-white table-responsive-md table-sm" style="border-radius: 5px;" id="withdraw">
                            <thead>
                                <tr>
                                    @foreach($withdraw_infos[0] as $key => $value)
                                        @if($key == 'batch_id' || $key == 'block' || $key == 'created_at' || $key == 'store_id' || $key == 'id')

                                        @elseif($key == 'floor')
                                            <th scope="col">Location</th>
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
                                            @if($key == 'batch_id' || $key == 'block' || $key == 'created_at' || $key == 'store_id' || $key == 'id')

                                            @elseif($key == 'floor')
                                                <td>{{$withdraw_info['floor']}} | {{$withdraw_info['block']}}</td>

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
