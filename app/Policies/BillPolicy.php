<?php

namespace App\Policies;

use App\Models\Bill;
use App\Models\Booking;
use App\Models\Complaint;
use App\Models\User;

class BillPolicy
{
    /**
     * Determine whether the user can view the bill.
     */
    public function view(User $user, Bill $bill): bool
    {
        return $user->id === $bill->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the bill.
     */
    public function update(User $user, Bill $bill): bool
    {
        return $user->isAdmin();
    }
}

class BookingPolicy
{
    /**
     * Determine whether the user can view the booking.
     */
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the booking.
     */
    public function update(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the booking.
     */
    public function delete(User $user, Booking $booking): bool
    {
        return $user->id === $booking->user_id || $user->isAdmin();
    }
}

class ComplaintPolicy
{
    /**
     * Determine whether the user can view the complaint.
     */
    public function view(User $user, Complaint $complaint): bool
    {
        return $user->id === $complaint->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the complaint.
     */
    public function update(User $user, Complaint $complaint): bool
    {
        return $user->isAdmin();
    }
}
