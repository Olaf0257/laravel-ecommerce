<?php

namespace App\Listeners;

use App\Events\ProductDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MakeProductUnsearchable
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
     * @param  ProductDeleted  $event
     * @return void
     */
    public function handle(ProductDeleted $event)
    {
        // Change meilisearch key to use the master key instead of the public key to update searchable products
        config(['meilisearch.key' => env('MEILISEARCH_MASTER_KEY')]);
        
        $searchableProduct = $event->product->searchableProduct;
        collect([$searchableProduct])->unsearchable();
        $searchableProduct->delete();
    }
}
