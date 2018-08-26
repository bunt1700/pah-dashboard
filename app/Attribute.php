<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $type
 * @property string|null units
 */
class Attribute extends Model
{
    const TYPE_TEXT = 'text';

    const TYPE_NUMERIC = 'numeric';

    const TYPE_BOOLEAN = 'boolean';

    protected $table = 'attribute';

    public function productgroup(): BelongsTo
    {
        return $this->belongsTo('App\Productgroup');
    }

    public function values(): HasMany
    {
        return $this->hasMany('App\AttributeValue', 'attribute_id')
            ->orderByDesc('numeric')
            ->orderBy('text');
    }
}
