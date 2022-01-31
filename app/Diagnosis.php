<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Diagnosis extends Model
{
	use \OwenIt\Auditing\Auditable;
    protected $table = 'diagnosis';
    protected $guarded = array();
}
