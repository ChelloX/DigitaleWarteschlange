<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    public function poi() {
        return $this->hasMany("App\Poi");
    }
}
