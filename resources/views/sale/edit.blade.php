@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header text-center">Edit BILL</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('sale.update', $sale->id) }}">
                        
                        {{ method_field('PATCH') }}
                        @csrf
                        
                        <div class="form-group row">
                            <label for="bill_no" class="col-md-4 col-form-label text-md-right">Bill no.</label>

                            <div class="col-md-6">
                                <input id="bill_no" type="text" class="form-control @error('bill_no') is-invalid @enderror" oninput="this.value = this.value.toUpperCase()" name="bill_no" value="{{ old('bill_no') ?? $sale->bill_no }}" required autocomplete="bill_no" autofocus style="text-transform: uppercase">

                                @error('bill_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
						   <label for="customer_id" class="col-md-4 col-form-label text-md-right">Customer Name</label>
						   <div class="col-md-6">
							   <select class="form-control" id="customer_id" name="customer_id" value="{{ old('customer_id') }}">
									@foreach ($customers as $customer)
		 								<option name="customer_id" <?php echo ($customer['id'] == $sale->customer_id) ? 'selected' : ''?> value="{{ $customer['id'] }}">{{ $customer['name'] }}</option>
		 							@endforeach
							   </select>
						   </div>
                        </div>

                        <div class="form-group row">
						   <label for="item_id" class="col-md-4 col-form-label text-md-right">Item Name</label>
						   <div class="col-md-6">
                                <input id="item_id" type="text" class="form-control @error('item_id') is-invalid @enderror" name="item_id" value="{{$sale->item_name}}" disabled>
                                <input type="hidden" name="item_id" value="{{$sale->item_id}}">           
						   </div>
                        </div>

                        <div class="card alert-warning text-body pt-3 mb-3">
                            <div class="card-title text-center">
                                Sale
                            </div>
                            <div class="form-group row">
                                <label for="qty" class="col-md-4 col-form-label text-md-right">{{ __('Quantity') }}</label>

                                <div class="col-md-6">
                                    <input id="qty" type="text" class="form-control @error('qty') is-invalid @enderror" name="qty" value="{{ old('qty') ?? $sale->qty }}" required autocomplete="qty">

                                    @error('qty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount each') }}</label>

                                <div class="col-md-6">
                                    <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount') ?? $sale->amount }}" required autocomplete="amount">

                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="bill_date" class="col-md-4 col-form-label text-md-right">Bill date</label>

                            <div class="col-md-6">
                                <input id="bill_date" type="date" class="form-control{{ $errors->has('bill_date') ? ' is-invalid' : '' }}" name="bill_date" value="{{$sale->bill_date}}" required autofocus>

                                @if ($errors->has('bill_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="card alert-success text-body pt-3 mb-3">
                            <div class="card-title text-center">
                                Deposit
                            </div>
                            <div class="form-group row">
                                <label for="given_amount" class="col-md-4 col-form-label text-md-right">{{ __('Amount given') }}</label>

                                <div class="col-md-6">
                                    <input id="given_amount" type="text" class="form-control @error('given_amount') is-invalid @enderror" value="{{ old('given_amount') ?? $sale->given_amount }}" name="given_amount" autocomplete="given_amount">

                                    @error('given_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="given_assets" class="col-md-4 col-form-label text-md-right">{{ __('Crate given') }}</label>

                                <div class="col-md-6">
                                    <input id="given_assets" type="text" class="form-control @error('given_assets') is-invalid @enderror" value="{{ old('given_assets') ?? $sale->given_assets }}" name="given_assets" autocomplete="given_assets">

                                    @error('given_assets')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" value="{{ old('description') ?? $sale->description }}" name="description" autocomplete="description" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to Edit?')">
                                    {{ __('Add') }}
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
