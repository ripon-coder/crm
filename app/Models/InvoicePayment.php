<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($payment) {
            $payment->invoice->updatePaymentStatus();
        });
        
        static::deleted(function ($payment) {
            $payment->invoice->updatePaymentStatus();
        });
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
