@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Bill</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('sale.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="bill_no" class="col-md-4 col-form-label text-md-right">{{ __('Bill no.') }}</label>

                            <div class="col-md-6">
                                <input id="bill_no" type="text" class="form-control @error('bill_no') is-invalid @enderror" name="bill_no" value="{{ old('bill_no') }}" required autocomplete="bill_no" autofocus>

                                @error('bill_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="customer_id" class="col-md-4 col-form-label text-md-right">{{ __('Customer Name') }}</label>

                            <div class="col-md-6">
                                <input id="customer_id" type="text" class="form-control @error('customer_id') is-invalid @enderror" name="customer_id" value="{{ old('customer_id') }}" required autocomplete="customer_id">

                                @error('customer_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="item_id" class="col-md-4 col-form-label text-md-right">{{ __('Item Name') }}</label>

                            <div class="col-md-6">
                                <input id="item_id" type="text" class="form-control @error('item_id') is-invalid @enderror" name="item_id" required autocomplete="item_id">

                                @error('item_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="qty" class="col-md-4 col-form-label text-md-right">{{ __('Quantity') }}</label>

                            <div class="col-md-6">
                                <input id="qty" type="text" class="form-control @error('qty') is-invalid @enderror" name="qty" required autocomplete="qty">

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
                                <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" required autocomplete="amount">

                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bill_date" class="col-md-4 col-form-label text-md-right">Bill date</label>

                            <div class="col-md-6">
                                <input id="bill_date" type="date" class="form-control{{ $errors->has('bill_date') ? ' is-invalid' : '' }}" name="bill_date" value="{{ old('bill_date') }}" required autofocus>

                                @if ($errors->has('bill_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
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
