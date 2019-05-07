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

            $topupBalance = TopupBalance::create($request->all());

            $order = Order::create([
                'user_id'           => Auth::user()->id,
                'topup_balance_id'  => $topupBalance->id,
                'order_no'          => Helper::getRandomInt(),
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            
            return back()->withError($e->getMessage())->withInput();
        }

        DB::commit();

        $tax    = config('topup.tax');
        $total  = ($topupBalance->value*$tax/100)+$topupBalance->value;

        return view('order.success_order_topup', compact(
            'topupBalance', 
            'order',
            'total'
        ));
    }
}
