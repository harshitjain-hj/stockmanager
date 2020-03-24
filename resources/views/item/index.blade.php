@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <div class="row ">
                        <div class="col"><h1>Items</h1></div>
                        <div class="col"><a type="button" class="btn btn-secondary" href="{{ route('item.create') }}"><span class="material-icons pr-1 " style="vertical-align: -2px;">add_circle</span><span style="vertical-align: 4px;" >ADD</span></a></div>
                    </div>
                </div>

                <div class="card-body">
                    <?php $items = json_decode( $items, true ); ?>
                    <table class="table table-hover table-responsive-lg">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
