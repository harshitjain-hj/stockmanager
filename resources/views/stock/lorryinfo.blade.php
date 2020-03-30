@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <div class="row">
                        <div class="col"><h1 class="text-nowrap">Lorry Infos</h1></div>
                        <div class="col"><a type="button" class="btn btn-secondary" href="{{ route('stock.create') }}"><span class="material-icons pr-1 " style="vertical-align: -2px;">add_circle</span><span style="vertical-align: 4px;" >ADD</span></a></div>
                    </div>
                </div>

                <div class="card-body">
                    <?php $lorry_infos = json_decode( $lorry_infos, true ); ?>
                    @if(!empty($lorry_infos))
                        <table class="table table-hover table-sm table-responsive-lg">
                            <thead>
                                <tr>
                                    @foreach($lorry_infos[0] as $key => $value)
                                        @if($key == 'id' || $key == 'name' || $key == 'updated_at')

                                        @elseif($key == 'item_id')
                                        <th scope="col">Item Name</th>    
                                        @else
                                            <th scope="col">{{ $key }}</th>
                                        @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lorry_infos as $lorry_info)
                                    <tr>
                                        @foreach($lorry_info as $key => $value)
                                            @if($key == 'id' || $key == 'name' || $key == 'updated_at')

                                            @elseif($key == 'item_id')
                                                <td>{{$lorry_info['name']}}</td>
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
                            No records found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
