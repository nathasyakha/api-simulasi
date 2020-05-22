<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    protected $fillable = ['jenis_treatment', 'harga', 'waktu_pengerjaan', 'qty', 'subtotal'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
