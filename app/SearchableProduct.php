<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class SearchableProduct extends Model
{
    use Searchable;

    protected $fillable = [
        'objectID',
        'hierarchy_radio_lvl0',
        'hierarchy_radio_lvl1',
        'hierarchy_radio_lvl2',
        'hierarchy_radio_lvl3',
        'hierarchy_radio_lvl4',
        'hierarchy_radio_lvl5',
        'hierarchy_lvl0',
        'hierarchy_lvl1',
        'hierarchy_lvl2',
        'hierarchy_lvl3',
        'hierarchy_lvl4',
        'hierarchy_lvl5',
        'hierarchy_lvl6',
        'content',
        'url',
        'anchor',
    ];

    public function product()
    {
    	return $this->belongsTo('App\Product');
    }

}
