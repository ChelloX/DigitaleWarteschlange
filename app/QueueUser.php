<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QueueUser extends Model
{
    //
    public function queue() {
        return $this->belongsTo("App\Queue");
    }
}
