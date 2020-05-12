@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Item to Store</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store.store') }}" onsubmit="add.disabled = true; return true;">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Customer Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);" name="name" value="{{ old('name') }}" required autocomplete="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="item_name" class="col-md-4 col-form-label text-md-right">Item Name</label>

                            <div class="col-md-6">
                                <input id="item_name" type="text" class="form-control @error('item_name') is-invalid @enderror" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);" name="item_name" value="{{ old('item_name') }}" required autocomplete="item_name">
                                @error('item_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile_no" class="col-md-4 col-form-label text-md-right">Mobile no.</label>

                            <div class="col-md-6">
                                <input id="mobile_no" type="text" class="form-control @error('mobile_no') is-invalid @enderror" name="mobile_no" value="{{ old('mobile_no') }}" required autocomplete="mobile_no">

                                @error('mobile_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="qty" class="col-md-4 col-form-label text-md-right">Quantity</label>

                            <div class="col-md-6">
                                <input id="qty" type="text" class="form-control @error('qty') is-invalid @enderror" name="qty" value="{{ old('qty') }}" required autocomplete="qty">

                                @error('qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="monthly_amount" class="col-md-4 col-form-label text-md-right">Monthly amount</label>

                            <div class="col-md-6">
                                <input id="monthly_amount" type="text" class="form-control @error('monthly_amount') is-invalid @enderror" name="monthly_amount" value="{{ old('monthly_amount') }}" required autocomplete="monthly_amount">

                                @error('monthly_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="floor" class="col-md-4 col-form-label text-md-right">Floor</label>

                            <div class="col-md-6">
                                <input id="floor" type="text" class="form-control @error('floor') is-invalid @enderror" oninput="this.value = this.value.toUpperCase()" name="floor" value="{{ old('floor') }}" required autocomplete="floor">

                                @error('floor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="block" class="col-md-4 col-form-label text-md-right">Block</label>

                            <div class="col-md-6">
                                <input id="block" type="text" class="form-control @error('block') is-invalid @enderror" oninput="this.value = this.value.toUpperCase()" name="block" value="{{ old('block') }}" required autocomplete="block">

                                @error('block')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
                            <label for="storage_date" class="col-md-4 col-form-label text-md-right">Storage date</label>

                            <div class="col-md-6">
                                <input id="storage_date" type="date" class="form-control{{ $errors->has('storage_date') ? ' is-invalid' : '' }}" name="storage_date" value="<?php echo date("Y-m-d");?>" required autofocus>

                                @if ($errors->has('storage_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);" value="{{ old('description') }}" autocomplete="description" autofocus>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" name="add" class="btn btn-primary">
                                    {{ __('Add to Store') }}
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
