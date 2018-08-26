<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AffiliateDeliveryMethod extends Model
{
    protected $table = 'affiliate_delivery_methods';

    public function affiliate(): BelongsTo
    {
        return $this->belongsTo('App\Affiliate');
    }
}
