<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment_type extends Model
{
    protected $guarded = [];

    public function detail_transacts()
    {
        return $this->hasMany(Detail_Transact::class);
    }

    public function treatment_prices()
    {
        return $this->hasMany(Treatment_Price::class);
    }
}
