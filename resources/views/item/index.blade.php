@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            @if(\Session::has('success'))
                <div class="alert alert-dismissible alert-success col-md-8 mb-1 p-2" style="margin: auto;" role="alert">
                {{\Session::get('success')}}
                    <button type="button" class="close p-2" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <div class="row ">
                        <div class="col"><h3 class="pt-1">Items</h3></div>
                        <div class="col"><a type="button" class="btn btn-secondary" href="{{ route('item.create') }}">ADD</a></div>
                    </div>
                </div>

                <div class="card-body">
                    <?php $items = json_decode( $items, true ); ?>
                    @if(!empty($items))
                        <table class="table table-hover table-sm table-responsive-sm">
                            <thead>
                                <tr style="text-transform:capitalize;">
                                    @foreach($items[0] as $key => $value)
                                        <th scope="col">{{ $key}}</th>
                                    @endforeach
                                    <th scope="col">Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        @foreach($item as $key => $value)
                                            @if($key == 'id')
                                                <th scope="row">{{$value}}</th>                                           
                                            @else
                                                <td>{{$value}}</td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <a href="{{ route('item.edit', $item['id']) }}">
                                                <img src="{{ URL::asset('images/edit.png')}}" alt="Edit" style="height: 22px; width: 22px; display: block; margin: auto;">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert text-white bg-dark text-center" role="alert">
                            No item added.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
