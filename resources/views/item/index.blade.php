@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <a type="button" class="btn btn-primary" href="{{ route('item.create') }}"><strong>+ ADD</strong></a>
            {{$items}}
        </div>
    </div>
</div>
@endsection
