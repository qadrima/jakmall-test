<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Order;

class OrderController extends Controller
{
    public function index($order_no)
    {
    	$order = Order::where('order_no', $order_no)
    			->with(['topupBalance', 'product'])
    			->first();

    	if(!$order || $order->status_order > 0 || $order->user_id != Auth::user()->id)
    		return redirect('/');

    	return view('order.pay_order', compact(  
            'order'
        ));
    }

    public function payNow(Request $request)
    {
    	$order = Order::where('order_no', $request->order_no)
    			->with(['topupBalance', 'product'])
    			->first();

    	if(!$order || $order->status_order > 0 || $order->user_id != Auth::user()->id)
    		return redirect('/');

    	$pay = $order->topupBalance 
    			? $this->payNowTopupBalance($order)
    			: $this->payNowProduct($order);

    	return $pay 
    		? redirect('/')
    		: back()->withError('Pay order fail, please try again.')->withInput();
    }

    private function payNowTopupBalance($order)
    {	
    	// 1 success, 3 failed
    	$statusOrder = $this->successRate() ? 1 : 3;

    	$update = Order::where('id', $order->id)->update([
            'status_order' => $statusOrder
        ]);

    	return $update;
    }

    private function payNowProduct($order)
    {
    	return false;
    }

    private function successRate()
    {
    	// default jakarta :)
    	date_default_timezone_set('Asia/Jakarta');

    	$hour = intval(date('H'));

    	// If paid this is within 9AM to 5PM
    	// 90% = 9 or 40% = 4
    	$rate = ($hour >= 9 && $hour <= 17) ? 9 : 4;
    	$arr  = [];

    	for($i=0; $i<10; $i++)
    	{
    		if($rate>0)
    		{
    			$rate--;
    			array_push($arr, true);
    		}
    		else
    		{
    			array_push($arr, false);
    		}
    	}

    	$randomIndex = rand(0,9);

    	return $arr[$randomIndex];
    }
}
