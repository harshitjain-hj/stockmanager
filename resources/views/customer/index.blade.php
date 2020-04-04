@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="row card-header d-flex justify-content-around">
                    <div class="row">
                        <div class="px-3"><h3 class="pt-1">Customers</h3></div>
                        <div class="px-3">
                            <a type="button" class="btn btn-secondary mr-3" href="{{ route('customer.create') }}">ADD</a>
                            <button type="button" class="btn btn-primary" onclick="exportTableToExcel('customer', 'customer')">Save</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <?php $customers = json_decode( $customers, true ); ?>
                    @if(!empty($customers))
                        <table class="table table-hover table-sm table-responsive-sm" id="customer">
                            <thead>
                                <tr>
                                    @foreach($customers[0] as $key => $value)
                                        @if($key == 'created_at' || $key == 'updated_at')
                                                
                                        @else
                                            <th scope="col" class="align-middle">{{ $key}}</th>
                                        @endif
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        @foreach($customer as $key => $value)
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
                    @else
                        <div class="alert text-white bg-dark text-center" role="alert">
                            No customer recorded.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
