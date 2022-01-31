<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class DrugsMedsSubcat extends Model
{
	use \OwenIt\Auditing\Auditable;
    protected $table = 'ref_drugsubcat';
    protected $guarded = array();
}
