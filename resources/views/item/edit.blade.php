@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Add Item</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('item.update', $item['id']) }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Item name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);" name="name" value="{{ old('name') ?? $item['name'] }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sku" class="col-md-4 col-form-label text-md-right">{{ __('SKU') }}</label>

                            <div class="col-md-6">
                                <input id="sku" type="text" class="form-control @error('sku') is-invalid @enderror" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);" name="sku" value="{{ old('sku') ?? $item['sku'] }}" required autocomplete="sku">

                                @error('sku')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);" name="description" value="{{ old('description') ?? $item['description'] }}" autocomplete="description">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="asset" class="col-md-4 col-form-label text-md-right">{{ __('Asset') }}</label>

                            <div class="col-md-6 form-check">
                                <input class="form-check-input" type="hidden" name="asset" id="asset" value="0">
                                <input class="form-check-input" type="checkbox" name="asset" id="asset" <?php echo ($item['asset']) ? 'checked value="1"' : '';?> onclick="this.value = this.checked ? 1 : 0;">
                                <label class="form-check-label" for="gridCheck">
                                    Check if there is any asset associated.
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Image url') }}</label>

                            <div class="col-md-6">
                                <input id="image" type="text" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') ?? $item['image'] }}" autocomplete="image">

                                @error('image')
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
