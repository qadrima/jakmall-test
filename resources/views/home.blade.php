@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Order History</div>

                <div class="card-body">

                    @forelse ($orders as $order)
                        <div class="card">
                            <div class="card-body">

                                @if($order->topupBalance)
                                    <div class="row">
                                        <div class="col-md-8 col-sm-8">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    {{ $order->order_no }}
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    Rp {{ number_format($order->total, 0, '', '.') }}
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    {{ number_format($order->topupBalance->value, 0, '', '.') }} For {{ $order->topupBalance->mobile_number }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4" style="text-align: center">
                                            @if($order->status_order == 0)
                                                <a class="btn btn-primary" href="{{ url('/pay-now/' . $order->order_no) }}">Pay now</a>
                                            @elseif($order->status_order == 1)
                                                <p class="text-success">Success</p>
                                            @elseif($order->status_order == 2)
                                                <p class="text-danger">Cancelled</p>
                                            @elseif($order->status_order == 3)
                                                <p class="text-warning">Failed</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                        <br>
                    @empty
                        <div class="card">
                            <div class="card-body">Empty order.</div>
                        </div>
                    @endforelse


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
