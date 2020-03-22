<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    //

    public function poi() {
        return $this->belongsTo("App\Poi");
    }

    public function queueUser() {
        return $this->hasMany("App\QueueUser");
    }
}
