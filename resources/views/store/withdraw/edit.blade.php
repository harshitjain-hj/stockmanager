@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Withdraw Info</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('withdraw.update', $store['id']) }}">
                        {{ method_field('PATCH') }}
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Customer Name</label>

                            <div class="col-md-6">
                                <input name="batch_id" type="hidden" value="{{ $store['batch_id'] }}">
                                <input name="store_id" type="hidden" value="{{ $store['store_id'] }}">
                                <input id="name" type="text" readonly class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $store['name'] }}" autocomplete="name">
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
                                <input id="item_name" type="text" readonly class="form-control @error('item_name') is-invalid @enderror" name="item_name" value="{{ $store['item_name'] }}" autocomplete="item_name">
                                @error('item_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remain_qty" class="col-md-4 col-form-label text-md-right">Quantity remain</label>

                            <div class="col-md-6">
                                <input id="remain_qty" type="text" readonly class="form-control @error('remain_qty') is-invalid @enderror" name="remain_qty" value="{{ $store['remain_qty'] + $store['withdraw_qty'] }}" required autocomplete="remain_qty">

                                @error('remain_qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bill_no" class="col-md-4 col-form-label text-md-right">{{ __('Bill no.') }}</label>

                            <div class="col-md-6">
                                <input id="bill_no" type="text" class="form-control @error('bill_no') is-invalid @enderror" name="bill_no" value="{{ $store['bill_no'] }}" required autocomplete="bill_no" oninput="this.value = this.value.toUpperCase()">

                                @error('bill_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="withdraw_qty" class="col-md-4 col-form-label text-md-right">Withdraw Quantity</label>

                            <div class="col-md-6">
                                <input id="withdraw_qty" type="text" class="form-control @error('withdraw_qty') is-invalid @enderror" name="withdraw_qty" value="{{ $store['withdraw_qty'] }}" required autocomplete="withdraw_qty">

                                @error('withdraw_qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="lorry_no" class="col-md-4 col-form-label text-md-right">{{ __('Lorry no') }}</label>

                            <div class="col-md-6">
                                <input id="lorry_no" type="text" class="form-control @error('lorry_no') is-invalid @enderror" name="lorry_no" oninput="this.value = this.value.toUpperCase()" value="{{ $store['lorry_no'] }}" required autocomplete="lorry_no">

                                @error('lorry_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="withdraw_date" class="col-md-4 col-form-label text-md-right">Withdraw date</label>

                            <div class="col-md-6">
                                <input id="withdraw_date" type="date" class="form-control{{ $errors->has('withdraw_date') ? ' is-invalid' : '' }}" name="withdraw_date" value="{{$store['withdraw_date']}}" required autofocus>

                                @if ($errors->has('withdraw_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);" value="{{$store['description']}}" autocomplete="description" autofocus>

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
                                    {{ __('Withdraw') }}
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
