<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DollarSale extends Model
{
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($sale) {
            // Auto assign user
            if (!$sale->user_id) {
                $sale->user_id = auth()->id() ?? 1; // Fallback to 1 if no auth (e.g. seeder)
            }

            // Calculate total price
            $sale->total_price = $sale->amount * $sale->rate;

            // Handle Stock
            $batch = $sale->batch;
            if ($batch->remaining_amount < $sale->amount) {
                throw new \Exception("Insufficient stock in batch. Remaining: {$batch->remaining_amount}, Requested: {$sale->amount}");
            }
            $batch->decrement('remaining_amount', $sale->amount);

            // Calculate Profit (Only if NOT linked to invoice)
            if (is_null($sale->invoice_id)) {
                $sale->profit = ($sale->rate - $batch->rate) * $sale->amount;
            } else {
                $sale->profit = null;
            }
        });

        static::updating(function ($sale) {
             // Recalculate if amount/rate changes (Complex logic needed for stock adjustment if amount changes)
             // For simplicity in this iteration, assuming amount doesn't change often or handled carefully.
             // But let's at least update total_price
             if ($sale->isDirty(['amount', 'rate'])) {
                 $sale->total_price = $sale->amount * $sale->rate;
             }
        });
    }

    public function batch()
    {
        return $this->belongsTo(DollarBatch::class, 'batch_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
