<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class MunicipalCity extends Model
{
	use \OwenIt\Auditing\Auditable;
    protected $table = 'municipal_cities';
    protected $guarded = array();
}
