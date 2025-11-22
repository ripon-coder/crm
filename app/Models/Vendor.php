<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dollarBatches()
    {
        return $this->hasMany(DollarBatch::class);
    }

    protected $fillable = [
        'name',
        'phone',
        'email',
        'payment_method',
        'account_no',
        'default_rate',
        'notes',
    ];
}
