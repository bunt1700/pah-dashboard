<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property Productgroup $productgroup
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property string $brand
 * @property Offer $offer
 * @property Offer[] $offers
 * @property Image $image
 * @property Image[] $images
 * @property string $status
 * @property Attribute[] $details
 */
class Product extends Model
{
    const STATUS_IMPORTED = 'created';

    const STATUS_ACTIVE = 'active';

    const STATUS_UNAVAILABLE = 'unavailable';

    const STATUS_DELETED = 'deleted';

    protected $table = 'product';

    public function productgroup(): BelongsTo
    {
        return $this->belongsTo('App\Productgroup', 'productgroup_id')->with('subcategory');
    }

    public function offer(): HasOne
    {
        return $this->hasOne('App\Offer', 'product_id')->with('affiliate')->orderBy('price');
    }

    public function offers(): HasMany
    {
        $today = new Carbon();

        return $this->hasMany('App\Offer')
            ->with('affiliate')
            ->whereNull('valid_until')
            ->orWhereDate('valid_until', '>', $today)
            ->whereDate('valid_from', '<=', $today)
            ->orderBy('price');
    }

    public function image(): HasOne
    {
        return $this->hasOne('App\Image', 'product_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany('App\Image');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany('App\AttributeValue', 'product_id')->with('attribute');
    }
}