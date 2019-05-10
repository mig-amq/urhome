<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Relationship
    public function addtional_feature(){return $this->hasOne('App\AdditionalFeature');}
    public function subscription(){return $this->hasOne('App\Subscription');}
    public function user() {return $this->belongsTo('App\User');}
}
