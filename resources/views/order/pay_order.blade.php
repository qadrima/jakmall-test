@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <!--  -->
                <div class="card-header">
                    Pay your order 
                    <p class="text-secondary" style="float: right;"> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</p>
                </div>

                <!--  -->
                <div class="card-body">

                    <form method="POST" action="{{ route('pay_now_submit') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="order_no" class="col-md-4 col-form-label text-md-right">Order No.</label>

                            <div class="col-md-6">

                                <input 
                                    id="order_no" 
                                    type="text" 
                                    class="form-control" 
                                    name="order_no" 
                                    value="{{ $order->order_no }}"
                                    required
                                    readonly 
                                >

                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            
                            @if (session('error'))
                                <div class="col-md-8 offset-md-4">
                                    <p class="text-danger">{{ session('error') }}</p>
                                </div>
                            @endif

                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">Pay now</button>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
