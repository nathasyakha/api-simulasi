<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail_Transact extends Model
{
    protected $fillable = ['transact_id', 'treatment_price_id', 'treatment_type_id', 'qty', 'price', 'total'];

    public function transact()
    {
        return $this->belongsTo(Transact::class);
    }

    public function treatment_price()
    {
        return $this->belongsTo(Treatment_Price::class);
    }

    public function treatment_types()
    {
        return $this->belongsTo(Treatment_type::class);
    }
}
