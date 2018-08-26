<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Attribute $attribute
 * @property Product $product
 * @property-read string $name
 * @property-read string $type
 * @property bool|null $boolean
 * @property float|null $numeric
 * @property string|null $text
 * @property-read string|null units
 */
class AttributeValue extends Model
{
    protected $table = 'attribute_value';

    public function attribute(): BelongsTo
    {
        return $this->belongsTo('App\Attribute');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo('App\Product');
    }

    public function __get($property)
    {
        if (isset($this->{$property})) {
            return parent::__get($property);
        }

        return $this->attribute->{$property};
    }

    public function __toString()
    {
        switch ($this->attribute->type) {
            case Attribute::TYPE_NUMERIC:
                $value = number_format($this->numeric, 2);
                $value = rtrim($value, '0');
                $value = rtrim($value, '.');
                break;

            case Attribute::TYPE_BOOLEAN:
                $value = $this->boolean ? 'Ja' : 'Nee';
                break;

            case Attribute::TYPE_TEXT:
                $value = $this->text;
        }

        return trim($value.' '.$this->attribute->units);
    }
}
