@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="row card-header d-flex justify-content-around">
                    <div class="row">
                        <div class="px-3"><h3 class="pt-1">Sales</h3></div>
                        <div class="px-3">
                            <a type="button" class="btn btn-secondary mr-3" href="{{ route('sale.create') }}">ADD</a>
                            <button type="button" class="btn btn-primary" onclick="exportTableToExcel('sales', 'sales')">Save</button>    
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php $sales = json_decode( $sales, true ); ?>
                    <?php $customers = json_decode( $customers, true ); ?>
                    <?php $items = json_decode( $items, true ); ?>
                    @if(!empty($sales))
                        <table class="table table-hover table-sm table-responsive-md" id="sales">
                            <thead>
                                <tr>
                                    @foreach($sales[0] as $key => $value)
                                        @if($key == 'created_at' || $key == 'updated_at' || $key == 'id')
                                                
                                        @elseif ($key == 'customer_id')
                                            <th scope="col">Customer Name</th>
                                        @elseif ($key == 'item_id')
                                            <th scope="col">Item Name</th>
                                        @else
                                            <th scope="col" class="align-middle">{{ $key}}</th>
                                        @endif  
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $sale)
                                    <tr>
                                        @foreach($sale as $key => $value)
                                            @if($key == 'bill_no')
                                                <th scope="row">{{$value}}</th>
                                            @elseif($key == 'created_at' || $key == 'updated_at' || $key == 'id')

                                            @elseif ($key == 'customer_id')
                                                <?php 
                                                    $key = array_search($value, array_column($customers, 'name'));
                                                    $name = $customers[$key]['name'];
                                                    // dd($name);
                                                ?>
                                                <td>{{$name}}</td>
                                            @elseif ($key == 'item_id')
                                                <?php 
                                                    $key = array_search($value, array_column($items, 'name'));
                                                    $name = $items[$key]['name'];
                                                    $sku = $items[$key]['sku'];
                                                    // dd($name);
                                                ?>
                                                <td>{{$name}}|{{$sku}}</td>
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
                            Currently no sale.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
