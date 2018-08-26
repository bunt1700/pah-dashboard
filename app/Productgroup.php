<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Subcategory $subcategory
 * @property string $slug
 * @property string $name
 * @property Product[] $products
 */
class Productgroup extends NameModel
{
    protected $table = 'productgroup';

    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory');
    }

    public function products(): HasMany
    {
        return $this->hasMany('App\Product')->whereHas('offers');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany('App\Attribute')->orderBy('name');
    }
}
