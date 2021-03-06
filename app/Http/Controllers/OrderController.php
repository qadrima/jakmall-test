<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Helpers\Helper;

use App\Order;
use App\Product;

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
    			->with(['product'])
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
        $update = Product::where('id', $order->product->id)->update([
            'shipping_code' => Helper::getRandomAlphanumeric(8)
        ]);

        if($update)
        {
            $update = Order::where('id', $order->id)->update([
                'status_order' => 1
            ]);
        }

        return $update;
    }

    private function successRate()
    {
    	$hour = intval(date('H'));

    	// If paid this is within 9AM to 5PM
    	// 90% = 9 or 40% = 4
    	$rate = ($hour >= 9 && $hour <= 17) ? 9 : 4;

    	$arrPossibility  = []; // [true, false, false, ..]

    	for($i=0; $i<10; $i++)
    	{
    		if($rate>0)
    		{
    			$rate--;
    			array_push($arrPossibility, true);
    		}
    		else
    		{
    			array_push($arrPossibility, false);
    		}
    	}

        // ~
        Log::info('Hour : '. $hour .' | Possibility : '.json_encode($arrPossibility));

        // random kemungkinan berhasil.
    	return $arrPossibility[rand(0,9)];
    }
}
