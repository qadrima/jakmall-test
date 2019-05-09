@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Order History 
                    <form style="float: right;" method="POST" action="{{ route('search') }}">
                        @csrf
                        <input 
                            type="text" 
                            class="form-control" 
                            name="search" 
                            value="{{ isset($search) ? $search : '' }}"
                            placeholder="Search order no.." 
                        >
                    </form>
                </div>

                <div class="card-body">

                    @forelse ($orders as $order)
                        <div class="card">
                            <div class="card-body">

                                @if($order->topupBalance)
                                    @include('order._path.topup_balance_list')
                                @elseif($order->product)
                                    @include('order._path.product_list')
                                @endif

                            </div>
                        </div>
                        <br>
                    @empty
                        <div class="card">
                            <div class="card-body">{{ isset($search) ? 'Not found search of order number '.$search : 'Empty order' }}.</div>
                        </div>
                    @endforelse

                    {{ $orders->links() }}

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
