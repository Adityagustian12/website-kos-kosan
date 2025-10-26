<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'price',
        'description',
        'facilities',
        'status',
        'capacity',
        'original_capacity',
        'area',
        'images',
    ];

    protected $casts = [
        'facilities' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
    ];

    /**
     * Get bookings for this room
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get bills for this room
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * Get complaints for this room
     */
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    /**
     * Check if room is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Check if room is occupied
     */
    public function isOccupied(): bool
    {
        return $this->status === 'occupied';
    }

    /**
     * Check if room is under maintenance
     */
    public function isMaintenance(): bool
    {
        return $this->status === 'maintenance';
    }
}
