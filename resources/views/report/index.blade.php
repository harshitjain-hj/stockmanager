@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-around">
                    <div class="row ">
                        <div class="col text-nowrap"><h2>Customer Summary</h2></div>
                        <!-- <div class="col"><a type="button" class="btn btn-secondary" href="{{ route('sale.create') }}"><span class="material-icons pr-1 " style="vertical-align: -2px;">add_circle</span><span style="vertical-align: 4px;" >ADD</span></a></div> -->
                    </div>
                </div>

                <div class="card-body">
                    <?php $repos = json_decode( $repos, true ); ?>
                    <?php $customers = json_decode( $customers, true ); ?>
                    <?php $items = json_decode( $items, true ); ?>
                    @if(!empty($repos))
                        <table class="table table-hover table-sm table-responsive-lg">
                            <thead>
                                <tr>
                                    @foreach($repos[0] as $key => $value)
                                        @if($key == 'created_at' || $key == 'updated_at' || $key == 'id')

                                        @elseif ($key == 'customer_id')
                                            <th scope="col">customer_name</th>
                                        @elseif ($key == 'item_id')
                                            <th scope="col">item_name</th>        
                                        @else
                                            <th scope="col">{{ $key}}</th>
                                        @endif  
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($repos as $repo)
                                    <tr>
                                        @foreach($repo as $key => $value)
                                            @if($key == 'created_at' || $key == 'updated_at' || $key == 'id')

                                            @elseif ($key == 'customer_id')
                                                <?php 
                                                    $key = array_search($value, array_column($customers, 'name'));
                                                    $name = $customers[$key]['name'];
                                                    // dd($name);
                                                ?>
                                                <td>{{$name}}</td>
                                            @elseif ($key == 'item_id')
                                                <?php 
                                                    $key = array_search($value, array_column($items, 'name'));
                                                    $name = $items[$key]['name'];
                                                    $sku = $items[$key]['sku'];
                                                    // dd($name);
                                                ?>
                                                <td>{{$name}}|{{$sku}}</td>
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
                            No bill added since.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
