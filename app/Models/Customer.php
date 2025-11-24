<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dollarSales()
    {
        return $this->hasMany(DollarSale::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function dollarRequests()
    {
        return $this->hasMany(DollarRequest::class);
    }

    public function projectLeads()
    {
        return $this->hasMany(ProjectLead::class);
    }

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'national_id',
        'notes',
        'is_active',
    ];
}
