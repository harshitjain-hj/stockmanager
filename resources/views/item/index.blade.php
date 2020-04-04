@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                                <tr>
                                    @foreach($items[0] as $key => $value)
                                        @if($key == 'image')
                                                
                                        @else
                                            <th scope="col">{{ $key}}</th>
                                        @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        @foreach($item as $key => $value)
                                            @if($key == 'id')
                                                <th scope="row">{{$value}}</th>
                                            @elseif($key == 'image')

                                            @else
                                                <td>{{$value}}</td>
                                            @endif
                                        @endforeach
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
