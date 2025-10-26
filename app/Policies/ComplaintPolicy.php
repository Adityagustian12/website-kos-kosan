<?php

namespace App\Policies;

use App\Models\Complaint;
use App\Models\User;

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
