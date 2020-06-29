@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <div class="row">
                        <div class="px-3"><h4 class="text-nowrap pt-1">Lorry Infos</h4></div>
                        <div class="px-3"><a type="button" class="btn btn-secondary mr-3" href="{{ route('stock.create') }}">ADD</a><button type="button" class="btn btn-primary" onclick="exportTableToExcel('lorry_infos', 'lorry_infos')">Save</button></div>
                    </div>
                </div>

                <div class="card-body">
                    <?php $lorry_infos = json_decode( $lorry_infos, true ); ?>
                    @if(!empty($lorry_infos))
                        <table class="table table-hover table-sm table-responsive-md text-center" id="lorry_infos">
                            <thead style="text-transform:capitalize;">
                                <tr>
                                    @foreach($lorry_infos[0] as $key => $value)
                                        @if($key == 'id' || $key == 'name' || $key == 'updated_at')

                                        @elseif($key == 'item_id')
                                        <th scope="col" class="align-middle">Item Name</th>    
                                        @else
                                            <th scope="col" class="align-middle">{{ $key }}</th>
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
                                            @elseif($key == 'created_at')
                                                <td>{{date("d-m-Y", strtotime($value))}}</td>
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
