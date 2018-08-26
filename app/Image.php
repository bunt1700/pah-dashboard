<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Product $product
 * @property string $url
 */
class Image extends Model
{
    protected $table = 'image';

    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Product');
    }

    public function __toString()
    {
        return $this->url;
    }
}
