<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;
}
