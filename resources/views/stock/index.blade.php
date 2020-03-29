@extends('layouts.app')

@section('content')

<?php $stocks = json_decode( $stocks, true ); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row row-cols-1 justify-content-center row-cols-md-3">
                @foreach($stocks as $stock) 
                    <div class="col mb-4">
                        <div class="card text-white bg-danger h-60">
                            <div class="row no-gutters">
                                <div class="col-md-5 p-3 align-middle">
                                    <h1 class="display-4 text-center">{{$stock['unit_remain']}}</h1>
                                    <p class="card-text text-center">{{$stock['description']}}</p>
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{$stock['name']}}</h5>
                                        <p class="card-text">{{$stock['description']}}</p>
                                        <small class="text-white">Last updated at {{$stock['updated_at']}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection
