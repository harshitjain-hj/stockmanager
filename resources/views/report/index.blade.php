@extends('layouts.app')

@section('content')
<?php $repos = json_decode( $repos, true ); ?>
<?php $customers = json_decode( $customers, true ); ?>
<?php $items = json_decode( $items, true ); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header justify-content-around row no-gutters">
                        <div class="col-sm-7 text-center">
							<h4 class="pt-1">Customer's Report</h4>
						</div>
                        <div class="input-group col-sm-5">
							<div class="input-group-prepend">
								<span class="input-group-text" id="basic-addon">Customer</span>
							</div>
							<select onchange="if (this.value) window.location.href='repo/'+ this.value" class="custom-select">
									<option selected>Choose customer...</option>
								@foreach($repos as $repo)
                                    {{$repo['name']}}
				  					<option value="{{$repo['customer_id']}}">{{$repo['name']}}</option>
			  					@endforeach
							</select>
                            <button type="button" class="btn btn-primary ml-2" onclick="exportTableToExcel('report', 'report')">Save</button>
						</div>
                </div>

                <div class="card-body">
                    @if(!empty($repos))
                        <table class="table table-hover table-sm table-responsive-md" id="report">
                            <thead>
                                <tr>
                                    @foreach($repos[0] as $key => $value)
                                        @if($key == 'created_at' || $key == 'updated_at' || $key == 'id' || $key == 'name')

                                        @elseif ($key == 'customer_id')
                                            <th scope="col" class="align-middle">Customer Name</th>
                                        @elseif ($key == 'item_id')
                                            <th scope="col" class="align-middle">Item Name</th>        
                                        @else
                                            <th scope="col" class="align-middle">{{ $key}}</th>
                                        @endif  
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($repos as $repo)
                                    <tr onclick="window.location='/repo/{{$repo['customer_id']}}'">
                                        @foreach($repo as $key => $value)
                                            @if($key == 'created_at' || $key == 'updated_at' || $key == 'id' || $key == 'name')

                                            @elseif ($key == 'customer_id')
                                                <td>{{$repo['name']}}</td>
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
