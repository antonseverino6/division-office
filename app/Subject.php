<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $guarded = [];

    public function areas() 
    {
        return $this->hasMany(Area::class);
    }
}
