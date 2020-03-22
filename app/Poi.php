<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poi extends Model
{
    //

    public function user() {
        return $this->hasMany("App\User");
    }

    public function location() {
        return $this->belongsTo("App\Location");
    }

    public function queue() {
        return $this->hasMany("App\Queue");
    }
}
