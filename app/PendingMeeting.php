<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class PendingMeeting extends Model
{
    use \OwenIt\Auditing\Auditable;
    protected $table = 'pending_meetings';
    protected $guarded = array();

    public function patient() {
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }

    public function doctor() {
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }

    public function encoded() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
