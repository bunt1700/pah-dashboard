<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property string $name
 * @property string $logoUrl
 */
class Affiliate extends Model
{
    protected $table = 'affiliate';

    public function offers(): HasMany
    {
        return $this->hasMany('App\Offer');
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough('App\Product', 'App\Offer');
    }

    public function deliveryMethods(): HasMany
    {
        return $this->hasMany('App\AffiliateDeliveryMethod');
    }
}
