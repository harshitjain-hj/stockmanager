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
                    <table class="table table-hover table-responsive-lg">
                        <thead>
                            <tr>
                                @foreach($repos[0] as $key => $value)
                                    @if($key == 'created_at' || $key == 'updated_at')
                                            
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
                                        @if($key == 'id')
                                            <th scope="row">{{$value}}</th>
                                        @elseif($key == 'created_at' || $key == 'updated_at')

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
