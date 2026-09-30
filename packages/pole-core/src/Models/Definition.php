<?php
namespace Modules\Pole\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Definition extends Model {
    use SoftDeletes;

    protected $guarded = [];
}
