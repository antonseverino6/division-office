<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $guarded = [];

    public function typeOfEmployee()
    {
        return $this->belongsTo(TypeOfEmployee::class);
    }
}
