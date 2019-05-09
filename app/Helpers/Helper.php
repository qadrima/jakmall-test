<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

use App\Order;

class Helper
{
    public static function getRandomInt()
    {
      	return str_shuffle('0123456789');
    }

    public static function getRandomAlphanumeric($range)
    {
    	return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $range);
    }

    public static function getUnpaidOrder()
    {
    	return Order::where('user_id', Auth::user()->id)
    			->where('status_order', 0)
    			->count();
    }
}