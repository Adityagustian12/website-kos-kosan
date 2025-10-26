<?php

namespace App\Http\Controllers\Seeker;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display seeker dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_bookings' => Booking::where('user_id', $user->id)->count(),
            'pending_bookings' => Booking::where('user_id', $user->id)->where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('user_id', $user->id)->where('status', 'confirmed')->count(),
            'rejected_bookings' => Booking::where('user_id', $user->id)->where('status', 'rejected')->count(),
        ];

        $recent_bookings = Booking::where('user_id', $user->id)
                                 ->with('room')
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();

        $can_become_tenant = $user->canBecomeTenant();

        return view('seeker.dashboard', compact('stats', 'recent_bookings', 'can_become_tenant'));
    }
}
