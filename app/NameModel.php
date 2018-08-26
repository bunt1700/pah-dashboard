<?php

namespace App;

use Carbon\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property Carbon $createdAt
 * @property Carbon $created_at
 * @property Carbon $updatedAt
 * @property Carbon $updated_at
 *
 * Although most models have a name, the NameModel is intended for models which are almost nothing but a name.
 * In example, the category, subcategory and productgroup do little more than providing a name and children.
 */
class NameModel extends Model
{
    public function __toString()
    {
        return $this->name;
    }
}