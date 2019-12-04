<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Representative extends Model
{
    protected $guarded = [];
    // protected $fillable = ['name'];

    public function user() 
    {
        return $this->hasMany(User::class);
    }
}
