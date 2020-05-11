@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <div class="row">
                        <div class="px-3"><h3 class="pt-1">Sales</h3></div>
                        <div class="px-3">
                            <a type="button" class="btn btn-secondary mr-3" href="{{ route('sale.create') }}">ADD</a>
                            <button type="button" class="btn btn-primary" onclick="exportTableToExcel('sales', 'sales')">Save</button>    
                        </div>
                    </div>
                </div>
                <div class="pt-1">
                    <nav aria-label="Page navigation flex-wrap" style="overflow-x: overlay;">
                        <ul class="pagination justify-content-center m-1 ">
                            <?php
                                $character = range('A', "Z");
                                echo '<ul class="pagination">';
                                echo '<li class="page-item active"><a class="page-link" style="padding: 5px;" href="sale?character=bill">Bill</a></li>';
                                foreach($character as $alphabet)
                                {
                                    echo '<li class="page-item"><a class="page-link" style="padding: 5px;" href="sale?character='.$alphabet.'"><strong>'.$alphabet.'</strong></a></li>';
                                }
                                echo '</ul>';
                            ?>
                        </ul>
                    </nav>
                </div>

                <div class="card-body pt-1">
                    <?php $sales = json_decode( $sales, true ); ?>
                    <?php $items = json_decode( $items, true ); ?>
                    @if(!empty($sales))
                        <table class="table table-hover table-sm table-responsive" id="sales">
                            <thead>
                                <tr>
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
                                    <th scope="col">Edit</th>
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
                                        <td><a href="{{ route('sale.edit', $sale['id']) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to Edit in {{$sale['name']}} bill no. {{$sale['bill_no']}}?')">Edit</a></td>
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
