<?php

namespace App;

use Carbon\Carbon;
use App\Events\ProductSaved;
use App\Events\ProductDeleted;
use Illuminate\Database\Eloquent\Model;
use Gloudemans\Shoppingcart\Facades\Cart;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use SearchableTrait;

    protected $fillable = ['quantity'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'products.name' => 10,
            'products.details' => 5,
            'products.description' => 2,
        ],
    ];

    protected $dispatchesEvents = [
        'saved' => ProductSaved::class,         // when a product is created or updated
        'deleting' => ProductDeleted::class
    ];

    public const NEW_PRODUCT_DURATION = 15;

    public function searchableProduct()
    {
        return $this->hasOne('App\SearchableProduct');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }

    public function getPriceAttribute($value)
    {
        return round($value, 2);
    }

    public function scopeMightAlsoLike($query)
    {
    	return $query->inRandomOrder()->take(4);
    }

    public function scopeAvailable($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function presentPrice($price = null)
    {
        // If price is not comming from cart (subtotal)
        if (! $price) {   
        	$price = number_format($this->price, 2, '.', ',');
        }

        return $price . ' EGP';
    }

    public function imgPath() 
    {
        return asset('images/' . $this->main_image);
    }

    public function getCartRowId($instance)
    {
        $itemCollection = Cart::instance($instance)->search(function($cartItem, $rowId) {
            return $cartItem->id == $this->id;
        });

        return $itemCollection->first() ? $itemCollection->first()->rowId : NULL;
    }

    public function isInWishlist()
    {
        return $this->checkCartDuplicates('wishlist');
    }

    public function isInCart()
    {
        return $this->checkCartDuplicates('default');
    }

    public function isAvailable()
    {
        return $this->quantity > 0;
    }

    public function isNew()
    {
        return Carbon::parse($this->created_at)->diffInDays(Carbon::now()) <= self::NEW_PRODUCT_DURATION;
    }

    protected function checkCartDuplicates($instance = 'default')
    {
        $duplicates = Cart::instance($instance)->search(function($cartItem, $rowId) {
            return $cartItem->id == $this->id;
        });

        return $duplicates->isNotEmpty() ? true : false;
    }
}
