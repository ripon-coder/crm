<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DollarRequest extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'payment_method',
        'transaction_id',
        'bank_name',
        'account_number',
        'dollar_amount',
        'dollar_rate',
        'total_cost',
        'transaction_proof',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
