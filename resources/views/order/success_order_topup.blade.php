@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <!--  -->
                <div class="card-header">Success!</div>

                <!--  -->
                <div class="card-body">

                    <br>
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Order No.</td>
                                    <td>{{$order->order_no}}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>Rp {{number_format($order->total, 0, '', '.')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <br>
                    <p>Your mobile phone number {{$topupBalance->mobile_number}} will receive Rp {{number_format($topupBalance->value, 0, '', '.')}}</p>

                    <br>

                    <a class="btn btn-primary" href="{{ url('/pay-now/' . $order->order_no) }}">Pay now</a>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
