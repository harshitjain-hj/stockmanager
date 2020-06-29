@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Edit Customer Details</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('customer.update', $customer_info['id']) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $customer_info['name']}}" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $customer_info['address']}}" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobileno" class="col-md-4 col-form-label text-md-right">{{ __('Mobile no') }}</label>

                            <div class="col-md-6">
                                <input id="mobileno" type="tel" class="form-control @error('mobileno') is-invalid @enderror" pattern="[0-9]{10}" name="mobileno" value="{{$customer_info['mobileno']}}">

                                @error('mobileno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="other" class="col-md-4 col-form-label text-md-right">{{ __('Other no') }}</label>

                            <div class="col-md-6">
                                <input id="other" type="tel" class="form-control @error('other') is-invalid @enderror" pattern="[0-9]{10}" name="other" value="{{$customer_info['other']}}">

                                @error('other')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edit') }}
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
