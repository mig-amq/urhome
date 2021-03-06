<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $fillable = [
        "PropertyType"
    ];
    
    // Relationships
    public function property() {return $this->hasMany('App\Property', 'id', 'PropertyID');}
}
