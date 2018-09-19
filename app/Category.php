<?php

namespace App;

use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property Subcategory[] $subcategories
 * @property string $slug
 * @property string $name
 * @property string $image
 */
class Category extends NameModel
{
    protected $table = 'category';

    public function subcategories()
    {
        return $this->hasMany('App\Subcategory');
    }

    public function productgroups()
    {
        return $this->hasManyThrough('App\Productgroup', 'App\Subcategory');
    }

    public static function allWithProducts(array $columns = ['*'])
    {
        return self::query()->whereHas('subcategories')->get($columns);
    }
}
