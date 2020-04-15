@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="justify-content-around row no-gutters">
                        <div class="col-sm-7 text-center p-1">
                            <a type="button" href="{{ route('store.create') }}" class="btn text-primary btn-outline-primary"><strong>+ Add</strong></a>
						</div>
                        <div class="input-group col-sm-5 p-1">
							<div class="input-group-prepend">
								<span class="input-group-text bg-primary text-white" id="basic-addon">Customer</span>
							</div>
							<select onchange="if (this.value) window.location.href='store/'+ this.value" class="custom-select">
								<option selected>Choose customer...</option>
								@foreach($stores as $store)
				  					<option value="{{$store['store_id']}}">{{$store['name']}}</option>
			  					@endforeach
							</select>
						</div>
                </div>
            <hr class="bg-secondary">
            @if(!empty($stores))
                <div class="row row-cols-1 justify-content-center row-cols-md-3">
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
                                                <h4 class="">{{$store['name']}}</h4>
                                                <p class="">{{$store['item_name']}} | {{$store['description']}}</p>
                                                <small class="text-white">Last updated at {{date('d-m-Y', strtotime($store['updated_at']))}}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
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
