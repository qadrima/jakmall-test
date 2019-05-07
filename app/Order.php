<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = [
		'user_id',
		'product_id',
		'topup_balance_id',
		'order_no',
		'status_order'
	];

	public function topupBalance()
    {
        return $this->belongsTo('App\TopupBalance');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
