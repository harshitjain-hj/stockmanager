@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <div class="row ">
                        <div class="col"><h1>Sales</h1></div>
                        <div class="col"><a type="button" class="btn btn-secondary" href="{{ route('sale.create') }}"><span class="material-icons pr-1 " style="vertical-align: -2px;">add_circle</span><span style="vertical-align: 4px;" >ADD</span></a></div>
                    </div>
                </div>

                <div class="card-body">
                    <?php $sales = json_decode( $sales, true ); ?>
                    <?php $customers = json_decode( $customers, true ); ?>
                    <?php $items = json_decode( $items, true ); ?>
                    @if(!empty($sales))
                        <table class="table table-hover table-sm table-responsive-lg">
                            <thead>
                                <tr>
                                    @foreach($sales[0] as $key => $value)
                                        @if($key == 'bill_no')
                                            <th scope="row">{{$key}}</th>
                                        @elseif($key == 'created_at' || $key == 'updated_at' || $key == 'id')
                                                
                                        @elseif ($key == 'customer_id')
                                            <th scope="col">customer_name</th>
                                        @elseif ($key == 'item_id')
                                            <th scope="col">item_name</th>
                                        @else
                                            <th scope="col">{{ $key}}</th>
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
