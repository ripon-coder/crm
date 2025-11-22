<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DollarBatch extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($batch) {
            $batch->total_cost = $batch->dollar_amount * $batch->rate;
            $batch->remaining_amount = $batch->dollar_amount;
        });

        static::updating(function ($batch) {
             if ($batch->isDirty(['dollar_amount', 'rate'])) {
                $batch->total_cost = $batch->dollar_amount * $batch->rate;
             }
        });
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function dollarSales()
    {
        return $this->hasMany(DollarSale::class);
    }
}
