@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add withdraw Info</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store.update', $store->id) }}">
                        @csrf

                        @method('PATCH')

                        <div class="form-group row">
                            <label for="withdraw_qty" class="col-md-4 col-form-label text-md-right">Withdraw quantity</label>

                            <div class="col-md-6">
                                <input id="withdraw_qty" type="text" class="form-control @error('withdraw_qty') is-invalid @enderror" name="withdraw_qty" value="{{ old('withdraw_qty')}}" required autocomplete="withdraw_qty">

                                @error('withdraw_qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="floor" class="col-md-4 col-form-label text-md-right">Floor</label>

                            <div class="col-md-6">
                                <input id="floor" type="text" class="form-control @error('floor') is-invalid @enderror" oninput="this.value = this.value.toUpperCase()" name="floor" value="{{ old('floor') ?? $store->floor}}" autocomplete="floor">

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
                                <input id="block" type="text" class="form-control @error('block') is-invalid @enderror" oninput="this.value = this.value.toUpperCase()" name="block" value="{{ old('block') ?? $store->block}}" autocomplete="block">

                                @error('block')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="withdraw_date" class="col-md-4 col-form-label text-md-right">Withdraw date</label>

                            <div class="col-md-6">
                                <input id="withdraw_date" type="date" class="form-control{{ $errors->has('withdraw_date') ? ' is-invalid' : '' }}" name="withdraw_date" value="{{ old('withdraw_date') }}" required autofocus>

                                @if ($errors->has('withdraw_date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
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
