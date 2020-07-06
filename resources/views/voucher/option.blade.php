@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-deck">
                <div class="card w-100 mx-auto my-2" style="max-width: 17rem;">
                    <a class="btn p-0 m-0" href="{{ route('option.sale', $id) }}">
                        <img src="https://i.pinimg.com/originals/c4/9a/20/c49a207e0f89c9290d98fd43a87a8cb0.gif" class="card-img-top" alt="...">
                        <div class="card-body p-1">
                            <h2 class="card-title mb-0">Sale Voucher</h2>
                        </div>
                    </a>
                </div>
                <div class="card w-100 mx-auto my-2" style="max-width: 17rem;">
                    <a class="btn p-0 m-0" href="{{ route('option.recieve', $id) }}">
                        <img src="https://seatoskylogistics.com/wp-content/uploads/2019/02/WH-02-Warehouse.gif" class="card-img-top" alt="...">
                        <div class="card-body p-1">
                        <h2 class="card-title mb-0">Cash/Crate Voucher</h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
