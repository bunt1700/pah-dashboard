<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class Model
 *
 * @package App
 * @property int $id
 * @property Carbon $createdAt
 * @property Carbon $created_at
 * @property Carbon $updatedAt
 * @property Carbon $updated_at
 */
class Model extends BaseModel
{
	public static function get($key): ?self {
		$instance = new static();
		return $instance->resolveRouteBinding($key);
	}

    // Overriding Eloquent's getter because ProNoob13 dislikes the snake_case naming scheme
    public function __get($key)
    {
        return parent::__get(snake_case($key));
    }

    // Overriding Eloquent's getter because ProNoob13 dislikes the snake_case naming scheme and void return value
    public function __set($key, $value)
    {
        parent::__set(snake_case($key), $value);

        return $value;
    }
}