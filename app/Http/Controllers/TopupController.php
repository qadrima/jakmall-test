<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Rules\Phone;
use App\Rules\Topup;

use App\TopupBalance;
use App\Order;

use App\Helpers\Helper;
use App\Jobs\CanceledOrder;

class TopupController extends Controller
{
    public function index()
    {
        $values = config('topup.values');

        return view('topup_balance', compact('values'));
    }

    public function create(Request $request)
    {
    	$request->validate([
            'mobile_number' 	=> ['required', 'numeric', new Phone],
            'value'         	=> ['required', 'numeric', new Topup]
        ]);

        try
        {
            DB::beginTransaction();

            $topupBalance   = TopupBalance::create($request->all());
            $tax            = config('topup.tax');
            $order          = Order::create([
                'user_id'           => Auth::user()->id,
                'topup_balance_id'  => $topupBalance->id,
                'order_no'          => Helper::getRandomInt(),
                'total'             => ($request->value*$tax/100)+$request->value
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollback();

            return back()->withError($e->getMessage())->withInput();
        }

        DB::commit();

        // Jobs | Canceled : order is not paid within 5 minutes of creation
        $this->dispatch((new CanceledOrder($order->id))->delay(300));

        return view('order.success_order_topup', compact(
            'topupBalance',
            'order'
        ));
    }
}
