<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Affiliate $affiliate
 * @property Product $product
 * @property string $slug
 * @property string $url
 * @property Carbon|null validFrom
 * @property Carbon|null validUntil
 * @property Price $price
 */
class Offer extends Model
{
    protected $table = 'offer';

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo('App\Affiliate')->with('deliveryMethods');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Product');
    }

    public function __get($property)
    {
        if(isset($this->{$property})) {
            return parent::__get($property);
        }

        return $this->affiliate->{$property};
    }


    public function getPriceAttribute(int $price): Price
    {
        return new Price($price);
    }

    public function setPriceAttribute($price)
    {
        if ($price instanceof Price) {
            $price = $price->asCents();
        }

        $this->attributes['price'] = $price;
    }
}
