@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Lorry Info</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('stock.store') }}">
                        @csrf

                        <div class="form-group row">
						   <label for="item_id" class="col-md-4 col-form-label text-md-right">Item name</label>
						   <div class="col-md-6">
							   <select class="form-control" id="item_id" name="item_id" value="{{ old('item_id') }}">
								   <option selected>Choose category...</option>
									@foreach ($items as $item)
		 								<option name="item_id" value="{{ $item['id'] }}">{{ $item['name'] }}</option>
		 							@endforeach
							   </select>
						   </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_weight" class="col-md-4 col-form-label text-md-right">{{ __('Total weight') }}</label>

                            <div class="col-md-6">
                                <input id="total_weight" type="text" class="form-control @error('total_weight') is-invalid @enderror" name="total_weight" value="{{ old('total_weight') }}" required autocomplete="total_weight">

                                @error('total_weight')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="arrived_unit" class="col-md-4 col-form-label text-md-right">{{ __('Arrived unit') }}</label>

                            <div class="col-md-6">
                                <input id="arrived_unit" type="text" class="form-control @error('arrived_unit') is-invalid @enderror" name="arrived_unit" value="{{ old('arrived_unit') }}" required autocomplete="arrived_unit">

                                @error('arrived_unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="created_unit" class="col-md-4 col-form-label text-md-right">{{ __('Created unit') }}</label>

                            <div class="col-md-6">
                                <input id="created_unit" type="text" class="form-control @error('created_unit') is-invalid @enderror" name="created_unit" value="{{ old('created_unit') }}" required autocomplete="created_unit">

                                @error('created_unit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="purchase_cost" class="col-md-4 col-form-label text-md-right">{{ __('Purchase cost') }}</label>

                            <div class="col-md-6">
                                <input id="purchase_cost" type="text" class="form-control @error('purchase_cost') is-invalid @enderror" name="purchase_cost" value="{{ old('purchase_cost') }}" required autocomplete="purchase_cost">

                                @error('purchase_cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="labour_cost" class="col-md-4 col-form-label text-md-right">{{ __('Labour cost') }}</label>

                            <div class="col-md-6">
                                <input id="labour_cost" type="text" class="form-control @error('labour_cost') is-invalid @enderror" name="labour_cost" value="{{ old('labour_cost') }}" required autocomplete="labour_cost">

                                @error('labour_cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lorry_cost" class="col-md-4 col-form-label text-md-right">Lorry cost</label>

                            <div class="col-md-6">
                                <input id="lorry_cost" type="text" class="form-control{{ $errors->has('lorry_cost') ? ' is-invalid' : '' }}" name="lorry_cost" value="{{ old('lorry_cost') }}" required autofocus>

                                @if ($errors->has('lorry_cost'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lorry_no" class="col-md-4 col-form-label text-md-right">{{ __('Lorry no') }}</label>

                            <div class="col-md-6">
                                <input id="lorry_no" type="text" class="form-control @error('lorry_no') is-invalid @enderror" name="lorry_no" oninput="this.value = this.value.toUpperCase()" value="{{ old('lorry_no') }}" required autocomplete="lorry_no">

                                @error('lorry_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unit_returned" class="col-md-4 col-form-label text-md-right">{{ __('Returned unit') }}</label>

                            <div class="col-md-6">
                                <input id="unit_returned" type="text" class="form-control @error('unit_returned') is-invalid @enderror" name="unit_returned" value="{{ old('unit_returned') }}" required autocomplete="unit_returned">

                                @error('unit_returned')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Stock') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
