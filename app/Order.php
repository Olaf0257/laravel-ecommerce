<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = [
		'user_id',
		'billing_email', 
		'billing_phone', 
		'billing_address', 
		'billing_country',
		'billing_city',
		'billing_state',
		'billing_postal_code',
		'shipping_address',
		'shipping_country',
		'shipping_city',
		'shipping_state',
		'shipping_postal_code',
		'cc_first_name',
		'cc_last_name',
		'cc_phone',
		'subtotal',
		'tax',
		'discount',
		'discount_code',
		'total',
		'payment_gateway',
		'transaction_id',
		'card_brand',
		'card_first_six_digits',
		'card_last_four_digits',
		'shipped',
		'error'
	];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function products()
    {
    	return $this->belongsToMany('App\Product')->withPivot('quantity');
    }

    public function scopeErrorFree($query)
    {
        return $query->where('error', null);
    }
}
