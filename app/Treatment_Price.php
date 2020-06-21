<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment_Price extends Model
{
    protected $fillable = ['treatment_type_id', 'harga', 'user_id'];

    public function detail_transacts()
    {
        return $this->hasMany(Detail_Transact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function treatment_type()
    {
        return $this->belongsTo(Treatment_type::class);
    }
}
