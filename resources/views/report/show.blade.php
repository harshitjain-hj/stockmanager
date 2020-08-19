@extends('layouts.app')

@section('content')
<?php if (isset($_GET['character'])) {
    $path = $_GET['character'];
} else {
    $path = 'casual';
}?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(\Session::has('success'))
                <div class="alert alert-dismissible alert-success col-md-8 mb-1 p-2" style="margin: auto;" role="alert">
                {{\Session::get('success')}}
                    <button type="button" class="close p-2" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <?php $items = json_decode( $items, true ); ?>

                    <nav class="nav nav-pills nav-fill lead">
                        <li class="nav-item nav-link">Customer Name: <span class="text-dark font-weight-bold">{{$repo['name']}}</span></li>
                        <li class="nav-item nav-link">Total Amount: <span class="text-primary font-weight-bold">{{$repo['total_amount']}}</span></li>
                        <li class="nav-item nav-link">Remain Amount: <span class="text-danger font-weight-bold">{{$repo['remain_amount']}}</span></li>
                        <li class="nav-item nav-link">Remain Assets: <span class="text-danger font-weight-bold">
                            @foreach(json_decode($repo['remain_assets'], true) as $item)
                                {{$item['asset_remain']}}
                                &nbsp;
                            @endforeach
                            </span></li>
                        <li class="nav-item nav-link">
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#repo_{{$repo['id']}}">Hard Modify</button>
                        </li>
                        <li class="nav-item nav-link"><button type="button" class="btn btn-primary" onclick="exportTableToExcel('{{$repo['name']}}', '{{$repo['name']}}')">Save</button></li>
					</nav>
                    <!-- Modal -->
                        <div class="modal fade" id="repo_{{$repo['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Sure you want to Modify?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="{{ route('repo.update', $repo['id']) }}">
                                        {{ method_field('PATCH') }}
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-row justify-content-center">
                                                <div class="form-group col-3">
                                                    <label for="remain_amount" class="col-form-label text-md-right">Remain Amount</label>
                                                </div>
                                                <div class="form-group col-4">
                                                    <input type="text" class="form-control" value="{{ $repo['remain_amount'] }}" disabled>
                                                </div>
                                                <div class="form-group col-1 px-0">
                                                    <img src="{{ URL::asset('images/arrow-right.png')}}" alt="Delete" style="height: 30px; width: 30px; display: block; margin: auto;">
                                                </div>
                                                <div class="form-group col-4">
                                                    <input id="remain_amount" type="text" class="form-control @error('remain_amount') is-invalid @enderror" name="remain_amount" value="{{ $repo['remain_amount'] }}" required autocomplete="remain_amount">

                                                    @error('remain_amount')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            @foreach(json_decode($repo['remain_assets'], true) as $item)
                                                <?php $key = array_search($item['asset_id'], array_column($items, 'id')); ?>
                                                <div class="form-row justify-content-center">
                                                    <div class="form-group col-3">
                                                        <label for="remain_assets" class="col-form-label text-md-right">Remain {{ $items[$key]['name'] }} {{ $items[$key]['sku'] }}</label>
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <input type="text" class="form-control" value="{{ $item['asset_remain'] }}" disabled>
                                                    </div>
                                                    <div class="form-group col-1 px-0">
                                                        <img src="{{ URL::asset('images/arrow-right.png')}}" alt="Delete" style="height: 30px; width: 30px; display: block; margin: auto;">
                                                    </div>
                                                    <div class="form-group col-4">
                                                        <input type="hidden" name="asset[{{$item['asset_id']}}][asset_id]" value="{{ $item['asset_id'] }}">
                                                        <input id="remain_assets" type="text" class="form-control @error('remain_assets') is-invalid @enderror" name="asset[{{$item['asset_id']}}][asset_remain]" value="{{ $item['asset_remain'] }}" required autocomplete="remain_assets">

                                                        @error('remain_assets')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to Edit?')">Modify</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                </div>

				<div class="p-1 d-flex justify-content-md-center" style="overflow-x:overlay;">
					<ul class="list-group list-group-horizontal">
					  <a class="page-link btn btn-secondary {{isset($_GET['character']) ? '' : 'active'}}" style="padding: 5px;" href="{{$repo['id']}}">Unpaid</a>
					  <a class="page-link btn btn-secondary {{$path == 'bill' ? 'active' : ''}}" style="padding: 5px;" href="?character=bill">Bill</a>
					  <?php $character = range('A', "Z"); ?>
					  @foreach($character as $alphabet)
					  	<a class="page-link btn btn-secondary {{$path == $alphabet ? 'active' : ''}}" style="padding: 5px;" href="?character={{$alphabet}}"><strong>{{$alphabet}}</strong></a>
					  @endforeach
					</ul>
				</div>

                <div class="card-body pt-1">
                <?php $sales = json_decode( $sales, true ); ?>
                @if(!empty($sales))
                    <table class="table table-hover table-sm table-responsive" id="{{$repo['name']}}">
                        <thead>
                            <tr style="text-transform:capitalize;">
                                @foreach($sales[0] as $key => $value)
                                    @if($key == 'created_at' || $key == 'updated_at' || $key == 'id' || $key == 'name')

                                    @elseif ($key == 'customer_id')
                                        <th scope="col" class="align-middle">Customer Name</th>
                                    @elseif ($key == 'item_id')
                                        <th scope="col" class="align-middle">Item Name</th>
                                    @else
                                        <th scope="col" class="align-middle">{{$key}}</th>
                                    @endif
                                @endforeach
                                <th scope="col" class="align-middle">Edit</th>
                                <th scope="col" class="align-middle">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    @foreach($sale as $key => $value)
                                        @if($key == 'bill_no')
                                            <th scope="row">{{$value}}</th>
                                        @elseif($key == 'created_at' || $key == 'updated_at' || $key == 'id' || $key == 'name')

                                        @elseif ($key == 'customer_id')
                                            <td>{{$sale['name']}}</td>
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
                                <td><a href="{{ route('sale.edit', $sale['id']) }}" onclick="return confirm('Are you sure you want to Edit in {{$sale['name']}} bill no. {{$sale['bill_no']}}?')"><img src="{{ URL::asset('images/edit.png')}}" alt="Delete" style="height: 22px; width: 22px; display: block; margin: auto;"></a></td>
                                <td><a data-toggle="modal" data-target="#bill_{{$sale['id']}}"><img src="{{ URL::asset('images/delete.png')}}" alt="Delete" style="height: 22px; width: 22px; display: block; margin: auto;"></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="alert text-white bg-dark text-center" role="alert">
                            Currently no sale.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
