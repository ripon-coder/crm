<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectLead extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'customer_id',
        'service_id',
        'title',
        'description',
        'status',
        'budget',
        'start_date',
        'end_date',
        'is_active',
        'notes',
    ];

    /**
     * Get the customer that owns the project lead.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get all payments for the project lead.
     */
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
