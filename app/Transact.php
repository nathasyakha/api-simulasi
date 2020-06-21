<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transact extends Model
{
    protected $fillable = ['user_id', 'amount', 'start_date', 'end_date', 'status'];

    public function detail_transacts()
    {
        return $this->hasMany(Detail_Transact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
