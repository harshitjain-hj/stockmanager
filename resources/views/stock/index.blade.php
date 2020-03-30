@extends('layouts.app')

@section('content')

<?php $stocks = json_decode( $stocks, true ); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($stocks))
                <div class="row row-cols-1 justify-content-center row-cols-md-3">
                    @foreach($stocks as $stock) 
                        <div class="col mb-4">
                            <div class=" text-white bg-danger h-60">
                                <div class="row no-gutters">
                                    <div class="col-md-5 p-3 align-middle">
                                        <h1 class="display-4 text-center">{{$stock['unit_remain']}}</h1>
                                        <p class="card-text text-center">{{$stock['description']}}</p>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{$stock['name']}}</h5>
                                            <p class="card-text">{{$stock['sku']}} | {{$stock['description']}}</p>
                                            <small class="text-white">Last updated at {{$stock['updated_at']}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert text-dark bg-white text-center" role="alert">
                    No item in stock.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
