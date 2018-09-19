<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Category $category
 * @property string $slug
 * @property string $name
 * @property Productgroup[] $productgroups
 */
class Subcategory extends NameModel
{
    protected $table = 'subcategory';

    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Category');
    }

    public function productgroups(): HasMany
    {
        return $this->hasMany('App\Productgroup');
    }
}
