<div class="row">
	<div class="col-md-8 col-sm-8">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<i><p class="text-secondary">{{ $order->order_no }}</p></i>
			</div>
			<div class="col-md-6 col-sm-6">
				<b><p class="text-secondary">Rp {{ number_format($order->total, 0, '', '.') }}</p></b>
			</div>
			<div class="col-md-12 col-sm-12">
				<p class="text-secondary">{{ $order->product->product }} that costs {{ number_format($order->product->price, 0, '', '.') }}</p>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-4" style="text-align: center">
		@if($order->status_order == 0)
			<a class="btn btn-primary" href="{{ url('/pay-now/' . $order->order_no) }}">Pay now</a>
		@elseif($order->status_order == 1)
			<p class="text-primary">Shipping code</p>
			<p class="text-primary">{{ $order->product->shipping_code }}</p>
		@elseif($order->status_order == 2)
			<p class="text-danger">Cancelled</p>
		@elseif($order->status_order == 3)
			<p class="text-warning">Failed</p>
		@endif
	</div>
</div>