<?php

namespace App\Listeners;

use App\Events\ProductSaved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MakeProductSearchable
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProductSaved  $event
     * @return void
     */
    public function handle(ProductSaved $event)
    {
        $product = $event->product;
        $searchableProduct = $product->searchableProduct;
        $quantity = $product->quantity;

        // We can't use meilisearch master key because it will be exposed to users
        // But it's ok for admins to use it
        if (! isset($_COOKIE['dontUpdateSearchable'])) {
            // Change meilisearch key to use the master key instead of the public key to update searchable products
            config(['meilisearch.key' => env('MEILISEARCH_MASTER_KEY')]);

            if ($searchableProduct) {
                // If true, then a product's been updated
                if ($quantity > 0) {
                    $searchableProduct->fill([
                        'hierarchy_radio_lvl2' => '<h3> '.$product->name.' </h3>',
                        'hierarchy_radio_lvl3' => $product->details,
                        'hierarchy_lvl2' => '<h3> '.$product->name.' </h3>',
                        'hierarchy_lvl3' => $product->details,
                        'content' => ' '.$product->description.' ',
                    ]);

                    $searchableProduct->save();
                } else {
                    collect([$searchableProduct])->unsearchable();
                    $searchableProduct->delete();
                }
            } else {
                // Else, then a product's been either created or updated
                if ($quantity > 0) {
                    $newSearchable = $product->searchableProduct()->create([
                        'objectID' => $product->id,
                        'hierarchy_radio_lvl0' => null,
                        'hierarchy_radio_lvl1' => null,
                        'hierarchy_radio_lvl2' => '<h3> '.$product->name.' </h3>',
                        'hierarchy_radio_lvl3' => $product->details,
                        'hierarchy_radio_lvl4' => null,
                        'hierarchy_radio_lvl5' => null,
                        'hierarchy_lvl0' => 'searchable_products',
                        // 'hierarchy_lvl1' => '<img src="'.$product->imgPath().'">',
                        'hierarchy_lvl1' => null,
                        'hierarchy_lvl2' => '<h3> '.$product->name.' </h3>',
                        'hierarchy_lvl3' => $product->details,
                        'hierarchy_lvl4' => null,
                        'hierarchy_lvl5' => null,
                        'hierarchy_lvl6' => null,
                        'content' => ' '.$product->description.' ',
                        'url' => "/shop/{$product->id}",
                        'anchor' => null,
                    ]);

                    collect([$newSearchable])->searchable();
                }
            }
        } else {
            setcookie('dontUpdateSearchable', '', time()-3600);
        }
    }
}
