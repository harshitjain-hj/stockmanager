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
                <div class="alert alert-dismissible alert-danger col-md-5 mb-1" style="margin: auto;" role="alert">
                {{\Session::get('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <div class="row">
                        <div class="px-3"><h3 class="pt-1">Bills</h3></div>
                        <div class="px-3">
                            <a type="button" class="btn btn-danger mr-3" href="{{ route('sale.create') }}">Sale</a>
                            <a type="button" class="btn btn-success mr-3" href="{{ route('sale.receive') }}">Receive</a>
                            <button type="button" class="btn btn-primary" onclick="exportTableToExcel('sales', 'sales')">Save</button>    
                        </div>
                    </div>
                </div>
                <div class="pt-1">
                    <nav aria-label="Page navigation flex-wrap" style="overflow-x: overlay;">
                        <ul class="pagination justify-content-center m-1 ">
                                <?php $character = range('A', "Z"); ?>
                                <ul class="pagination">
                                <li class="page-item {{isset($_GET['character']) ? '' : 'active'}}"><a class="page-link" style="padding: 5px;" href="sale">Recent</a></li>
                                <li class="page-item {{$path == 'bill' ? 'active' : ''}}"><a class="page-link" style="padding: 5px;" href="sale?character=bill">Bill</a></li>
                                @foreach($character as $alphabet)
                                    <li class="page-item {{$path == $alphabet ? 'active' : ''}}"><a class="page-link" style="padding: 5px;" href="sale?character={{$alphabet}}"><strong>{{$alphabet}}</strong></a></li>
                                @endforeach
                                </ul>
                        </ul>
                    </nav>
                </div>

                <div class="card-body pt-1">
                    <?php $sales = json_decode( $sales, true ); ?>
                    <?php $items = json_decode( $items, true ); ?>
                    @if(!empty($sales))
                        <table class="table table-hover table-sm table-responsive" id="sales">
                            <thead>
                                <tr style="text-transform:capitalize;">
                                    @foreach($sales[0] as $key => $value)
                                        @if($key == 'created_at' || $key == 'updated_at' || $key == 'id' || $key == 'name')
                                                
                                        @elseif ($key == 'customer_id')
                                            <th scope="col" class="align-middle">Customer Name</th>
                                        @elseif ($key == 'item_id')
                                            <th scope="col" class="align-middle">Item Name</th>
                                        @else
                                            <th scope="col" class="align-middle">{{ $key}}</th>
                                        @endif  
                                    @endforeach
                                    <th scope="col" class="align-middle">Edit</th>
                                    <th scope="col" class="align-middle">Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                    <tr class="<?php echo ($sale['amount'] == 0 && $sale['qty'] != 0) ? 'table-danger' : '' ?>">
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
                                                <td>{{$name}}|{{$sku}}</td>
                                            @else
                                                <td>{{$value}}</td>
                                            @endif
                                        @endforeach
                                        <td><a href="{{ route('sale.edit', $sale['id']) }}" onclick="return confirm('Are you sure you want to Edit in {{$sale['name']}} bill no. {{$sale['bill_no']}}?')"><img src="{{ URL::asset('images/edit.png')}}" alt="Edit" style="height: 22px; width: 22px; display: block; margin: auto;"></a></td>
                                        <td><a data-toggle="modal" data-target="#bill_{{$sale['id']}}"><img src="{{ URL::asset('images/delete.png')}}" alt="Delete" style="height: 22px; width: 22px; display: block; margin: auto;"></a></td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="bill_{{$sale['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalCenterTitle">Sure you want to Delete?</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-1">
                                                <dl class="row m-0">
                                                    <dt class="col-sm-4">Bill No</dt>
                                                    <dd class="col-sm-8">{{$sale['bill_no']}}</dd>
                                                    <dt class="col-sm-4">Customer Name</dt>
                                                    <dd class="col-sm-8">{{$sale['name']}}</dd>
                                                    <dt class="col-sm-4">Bill Date</dt>
                                                    <dd class="col-sm-8">{{$sale['bill_date']}}</dd>
                                                </dl>
                                            </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <a class="btn btn-danger" href="{{ route('sale.delete', $sale['id']) }}">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
