<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;

use App\Rules\Price;

use App\Product;
use App\Order;

class ProductController extends Controller
{
    public function index()
    {
        return view('product');
    }

    public function create(Request $request)
    {
    	$request->validate([
            'product' 			=> ['required'],
            'shipping_address' 	=> ['required'],
            'price' 			=> ['required', 'numeric', new Price]
        ]);

        try
        {
            DB::beginTransaction();

            $product = Product::create($request->all()); 

            $tax    = config('product.tax');
            $order  = Order::create([
                'user_id'       => Auth::user()->id,
                'product_id'    => $product->id,
                'order_no'      => Helper::getRandomInt(),
                'total'         => $request->price+$tax
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollback();

            return back()->withError($e->getMessage())->withInput();
        }

        DB::commit();

        return view('order.success_order_product', compact(
            'product',
            'order'
        ));
    }
}
