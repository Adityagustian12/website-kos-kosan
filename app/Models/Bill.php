<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'month',
        'year',
        'amount',
        'total_amount',
        'status',
        'due_date',
        'paid_at',
        'period_start',
        'period_end',
        'late_fee',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'late_fee' => 'decimal:2',
        'due_date' => 'date',
        'period_start' => 'date',
        'period_end' => 'date',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the user who owns this bill
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the room for this bill
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get payments for this bill
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if bill is paid
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if bill is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if bill is overdue
     */
    public function isOverdue(): bool
    {
        return $this->status === 'overdue';
    }

    /**
     * Calculate total amount
     */
    public function calculateTotal(): float
    {
        return $this->amount;
    }
}
