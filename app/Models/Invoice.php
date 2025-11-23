<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($invoice) {
            // Auto generate invoice number
            $lastInvoice = static::latest('id')->first();
            $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
            $invoice->invoice_number = 'INV-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            
            if (!$invoice->generated_at) {
                $invoice->generated_at = now();
            }
        });
    }

    public function recalculateTotals()
    {
        $this->total_amount = $this->dollarSales()->sum('amount');
        $this->total_price = $this->dollarSales()->sum('total_price');
        $this->save();
        
        $this->updatePaymentStatus();
    }

    public function updatePaymentStatus()
    {
        $totalPaid = $this->payments()->sum('amount');
        
        if ($totalPaid >= $this->total_price && $this->total_price > 0) {
            $this->payment_status = 'paid';
        } elseif ($totalPaid > 0) {
            $this->payment_status = 'partial';
        } else {
            $this->payment_status = 'unpaid';
        }
        $this->save();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function dollarSales()
    {
        return $this->hasMany(DollarSale::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
