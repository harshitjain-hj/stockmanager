@extends('layouts.app')

@section('content')
<?php
    $total_qty = 0;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="justify-content-around row no-gutters">
                        <div class="col-sm-8 text-center p-1 d-flex justify-content-around">
                            <a type="button" href="{{ route('store.create') }}" class="btn text-primary btn-outline-primary"><strong>+ Add</strong></a>                
                            <a class="btn text-primary btn-outline-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                Table View
                            </a>
                            <button type="button" class="btn text-success btn-outline-success mx-2" onclick="exportTableToExcel('store_repo', 'store_repo')">Save</button>
                        </div>
                        <div class="input-group col-sm-4 p-1">
							<div class="input-group-prepend">
								<span class="input-group-text bg-primary text-white" id="basic-addon">Customer</span>
							</div>
							<select onchange="if (this.value) window.location.href='store/'+ this.value" class="custom-select">
								<option selected>Choose customer...</option>
                                @foreach($names as $stores)
                                    @foreach($stores as $store)
                                        <option value="{{$store['store_id']}}">{{$store['name']}} | {{$store['item_name']}}</option>
                                    @endforeach
                                @endforeach
							</select>
						</div>
                </div>
            <hr class="bg-secondary">
            @if(!empty($stores))
                <div class="collapse pb-2 text-center" id="collapseExample">
                    <div class="card p-0 card-body">
                        <table class="table m-0 table-sm table-responsive-sm table-hover" id="store_repo">
                            <thead>
                                <tr>
                                    <th class="align-middle" scope="col">Name</th>
                                    <th class="align-middle" scope="col">Item Name</th>
                                    <th class="align-middle" scope="col">Floor</th>
                                    <th class="align-middle" scope="col">Block</th>
                                    <th class="align-middle" scope="col">Stored Qty</th>
                                    <th class="align-middle" scope="col">Remain Qty</th>
                                    <th class="align-middle" scope="col">Storage Date</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($table as $row)
                                
                                <tr>
                                    <th>{{$row->name}}</th>
                                    <td>{{$row->item_name}}</td>
                                    <td>{{$row->floor}}</td>
                                    <td>{{$row->block}}</td>
                                    <td>{{$row->stored_qty}}</td>
                                    <td>{{$row->remain_qty}}</td>
                                    <td>{{$row->storage_date}}</td>
                                </tr>

                                <?php $total_qty = $total_qty + $row->remain_qty ?>
                            @endforeach
                                <tr>
                                    <td colspan=4>Total Quantity</td>
                                    <td>{{$total_qty}}</td>
                                </tr>
                            </tbody>
                        </table>                       
                    </div>
                </div>
                <div class="row row-cols-1 justify-content-center row-cols-md-3">
                    @foreach($names as $stores)
                        @foreach($stores as $store) 
                            <a class="btn" href="{{ route('store.show', $store['store_id']) }}">
                                <div class="col mb-4">
                                    <div class=" text-white bg-primary h-60">
                                        <div class="row no-gutters">
                                            <div class="col-5 p-3 align-middle">
                                                <h1 class="display-4 text-center">{{$store['remain_qty']}}</h1>
                                                <h5 class="text-center">{{$store['floor']}} | {{$store['block']}}</h5>
                                            </div>
                                            <div class="col-7">
                                                <div class="card-body text-center">
                                                    <h4 class="mb-0">{{$store['name']}}</h4>
                                                    <p class="mb-0">{{$store['item_name']}}</p>
                                                    <small class="text-white">Updated at {{date('d-m-Y', strtotime($store['updated_at']))}}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        @for($i=count($stores) % 3; $i < 3; $i++)
                            @if($i == 0)
                                @break;
                            @endif
                            <div class="col m-0">
                            </div>
                        @endfor
                    @endforeach
                </div>
            @else
                <div class="alert text-dark bg-white text-center" role="alert">
                    No item in store.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
