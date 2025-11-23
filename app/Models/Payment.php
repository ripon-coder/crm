<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($payment) {
            // Update payment status based on payable type
            if ($payment->payable_type === Invoice::class && $payment->payable) {
                $payment->payable->updatePaymentStatus();
            }
        });
        
        static::deleted(function ($payment) {
            // Update payment status based on payable type
            if ($payment->payable_type === Invoice::class && $payment->payable) {
                $payment->payable->updatePaymentStatus();
            }
        });
    }

    /**
     * Get the owning payable model (Invoice, Lead, etc.)
     */
    public function payable()
    {
        return $this->morphTo();
    }
}
