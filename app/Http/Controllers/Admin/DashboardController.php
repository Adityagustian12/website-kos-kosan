<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Booking;
use App\Models\Complaint;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_rooms' => Room::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_tenants' => User::where('role', 'tenant')->count(),
            'total_revenue' => 'Rp ' . number_format(Booking::where('status', 'confirmed')->sum('booking_fee'), 0, ',', '.'),
        ];

        $recent_bookings = Booking::with(['user', 'room'])
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();

        $recent_complaints = Complaint::with('user')
                                     ->orderBy('created_at', 'desc')
                                     ->limit(5)
                                     ->get();

        return view('admin.dashboard', compact('stats', 'recent_bookings', 'recent_complaints'));
    }

    /**
     * Display rooms management
     */
    public function rooms()
    {
        $rooms = Room::withCount('bookings')->paginate(15);
        
        return view('admin.rooms', compact('rooms'));
    }

    /**
     * Store new room
     */
    public function storeRoom(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:50|unique:rooms,room_number',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'area' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room = Room::create([
            'room_number' => $request->room_number,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'area' => $request->area,
            'description' => $request->description,
            'facilities' => $request->facilities ?? [],
            'status' => 'available',
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('rooms', 'public');
                $images[] = $path;
            }
            $room->update(['images' => $images]);
        }

        return redirect()->route('admin.rooms')
                        ->with('success', 'Kamar berhasil ditambahkan.');
    }

    /**
     * Update room
     */
    public function updateRoom(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|string|max:50|unique:rooms,room_number,' . $room->id,
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'area' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'facilities' => 'nullable|array',
            'facilities.*' => 'string|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $room->update([
            'room_number' => $request->room_number,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'area' => $request->area,
            'description' => $request->description,
            'facilities' => $request->facilities ?? [],
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('rooms', 'public');
                $images[] = $path;
            }
            $room->update(['images' => $images]);
        }

        return redirect()->route('admin.rooms')
                        ->with('success', 'Kamar berhasil diperbarui.');
    }

    /**
     * Delete room
     */
    public function deleteRoom(Room $room)
    {
        // Check if room has active bookings
        if ($room->bookings()->whereIn('status', ['pending', 'confirmed'])->exists()) {
            return redirect()->route('admin.rooms')
                            ->with('error', 'Tidak dapat menghapus kamar yang memiliki booking aktif.');
        }

        // Check if room has unpaid bills
        if ($room->bills()->where('status', 'pending')->exists()) {
            return redirect()->route('admin.rooms')
                            ->with('error', 'Tidak dapat menghapus kamar yang memiliki tagihan belum dibayar.');
        }

        $room->delete();

        return redirect()->route('admin.rooms')
                        ->with('success', 'Kamar berhasil dihapus.');
    }

    /**
     * Duplicate room
     */
    public function duplicateRoom(Room $room)
    {
        $newRoom = $room->replicate();
        $newRoom->room_number = $room->room_number . '-Copy';
        $newRoom->status = 'available';
        $newRoom->save();

        return redirect()->route('admin.rooms')
                        ->with('success', 'Kamar berhasil diduplikasi.');
    }

    /**
     * Display room details
     */
    public function roomDetail(Room $room)
    {
        $room->load(['bookings.user', 'bills.user']);
        
        return view('admin.room-detail', compact('room'));
    }

    /**
     * Update room status
     */
    public function updateRoomStatus(Request $request, Room $room)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,maintenance',
        ]);

        $room->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status kamar berhasil diperbarui.');
    }

    /**
     * Display bookings management
     */
    public function bookings()
    {
        $bookings = Booking::with(['user', 'room'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);

        return view('admin.bookings', compact('bookings'));
    }

    /**
     * Display booking details
     */
    public function bookingDetail(Booking $booking)
    {
        $booking->load(['user', 'room']);
        
        return view('admin.booking-detail', compact('booking'));
    }

    /**
     * Confirm booking
     */
    public function confirmBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status' => 'confirmed',
            'admin_notes' => $request->admin_notes,
        ]);

        // When booking is confirmed, user is no longer occupying the room
        // Room remains available for new bookings
        $room = $booking->room;
        $room->update([
            'status' => 'available',
            'capacity' => $room->original_capacity ?? $room->capacity // Restore original capacity
        ]);

        // User remains as seeker and needs to book again
        // No role change to tenant

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi. User perlu melakukan booking baru untuk menempati kamar.');
    }

    /**
     * Move user into room (change booking to occupied)
     */
    public function moveIntoRoom(Request $request, Booking $booking)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        // Only confirmed bookings can be moved to occupied
        if ($booking->status !== 'confirmed') {
            return redirect()->back()
                           ->withErrors(['booking' => 'Hanya booking yang sudah dikonfirmasi yang dapat dipindahkan ke kamar.']);
        }

        $booking->update([
            'status' => 'occupied',
            'admin_notes' => $request->admin_notes,
        ]);

        // Update room status to occupied
        $room = $booking->room;
        if (!$room->original_capacity) {
            $room->update(['original_capacity' => $room->capacity]);
        }
        
        $room->update([
            'status' => 'occupied',
            'capacity' => 1
        ]);

        // Change user role from seeker to tenant
        if ($booking->user->role === 'seeker') {
            $booking->user->becomeTenant();
        }

        return redirect()->back()->with('success', 'User berhasil dipindahkan ke kamar dan menjadi penghuni.');
    }

    /**
     * Vacate room (simple room status update)
     */
    public function vacateRoom(Room $room)
    {
        // Only occupied rooms can be vacated
        if ($room->status !== 'occupied') {
            return redirect()->back()
                           ->withErrors(['room' => 'Hanya kamar yang terisi yang dapat dikosongkan.']);
        }

        // Update room status to available and set capacity to 0
        $room->update([
            'status' => 'available',
            'capacity' => 0
        ]);

        // Update any active bookings for this room to completed
        $room->bookings()
             ->where('status', 'occupied')
             ->update([
                 'status' => 'completed',
                 'check_out_date' => now()
             ]);

        return redirect()->back()->with('success', 'Kamar berhasil dikosongkan. Status kamar diubah menjadi tersedia dan kapasitas diatur menjadi 0.');
    }

    /**
     * Reject booking
     */
    public function rejectBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Booking berhasil ditolak.');
    }

    /**
     * Complete booking (penghuni keluar/pindah)
     */
public function completeBooking(Request $request, Booking $booking)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        // Update booking status to completed
        $booking->update([
            'status' => 'completed',
            'admin_notes' => $request->admin_notes,
            'check_out_date' => now(),
        ]);

        // Update room status to available and set capacity to 0 (kosong)
        $room = $booking->room;
        $room->update([
            'status' => 'available',
            'capacity' => 0 // Set to 0 when completed (kosong)
        ]);

        return redirect()->back()->with('success', 'Booking berhasil diselesaikan. Kamar telah tersedia kembali dan kapasitas diatur menjadi 0.');
    }

    /**
     * Display bills management
     */
    public function bills()
    {
        $bills = Bill::with(['user', 'room'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);

        return view('admin.bills', compact('bills'));
    }

    /**
     * Show create bill form
     */
    public function showCreateBillForm()
    {
        $tenants = User::where('role', 'tenant')
                      ->with(['bookings' => function($query) {
                          $query->where('status', 'confirmed')
                                ->with('room');
                      }])
                      ->get();

        return view('admin.create-bill', compact('tenants'));
    }

    /**
     * Create new bill
     */
    public function createBill(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|min:2024',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after:today',
        ]);

        $bill = Bill::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'month' => $request->month,
            'year' => $request->year,
            'amount' => $request->amount,
            'total_amount' => $request->amount,
            'due_date' => $request->due_date,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.bills')
                        ->with('success', 'Tagihan berhasil dibuat.');
    }

    /**
     * Display bill details
     */
    public function billDetail(Bill $bill)
    {
        $bill->load(['user', 'room', 'payments']);
        
        return view('admin.bill-detail', compact('bill'));
    }

    /**
     * Delete bill
     */
    public function deleteBill(Bill $bill)
    {
        // Check if bill has verified payments
        if ($bill->payments()->where('status', 'verified')->exists()) {
            return redirect()->route('admin.bills')
                            ->with('error', 'Tidak dapat menghapus tagihan yang sudah memiliki pembayaran terverifikasi.');
        }

        // Check if bill is already paid
        if ($bill->status === 'paid') {
            return redirect()->route('admin.bills')
                            ->with('error', 'Tidak dapat menghapus tagihan yang sudah dibayar.');
        }

        // Delete all related payments first
        $bill->payments()->delete();

        // Delete the bill
        $bill->delete();

        return redirect()->route('admin.bills')
                        ->with('success', 'Tagihan berhasil dihapus.');
    }

    /**
     * Display payments management
     */
    public function payments()
    {
        $payments = Payment::with(['user', 'bill', 'verifier'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);

        return view('admin.payments', compact('payments'));
    }

    /**
     * Display payment details
     */
    public function paymentDetail(Payment $payment)
    {
        $payment->load(['user', 'bill.room', 'verifier']);
        
        return view('admin.payment-detail', compact('payment'));
    }

    /**
     * Verify payment
     */
    public function verifyPayment(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $payment->update([
            'status' => $request->status,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        if ($request->status === 'verified') {
            // Update bill status to paid
            $payment->bill->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Get rooms data for API
     */
    public function getRoomsData()
    {
        $rooms = Room::select('id', 'room_number', 'price')->get();
        return response()->json($rooms);
    }

    /**
     * Display complaints management
     */
    public function complaints()
    {
        $complaints = Complaint::with(['user', 'room'])
                              ->orderBy('created_at', 'desc')
                              ->paginate(15);

        return view('admin.complaints', compact('complaints'));
    }

    /**
     * Display complaint details
     */
    public function complaintDetail(Complaint $complaint)
    {
        $complaint->load(['user', 'room']);
        
        return view('admin.complaint-detail', compact('complaint'));
    }

    /**
     * Update complaint status
     */
    public function updateComplaintStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,resolved,closed',
            'priority' => 'nullable|in:low,medium,high,urgent',
            'admin_response' => 'nullable|string|max:1000',
        ]);

        $data = [
            'status' => $request->status,
        ];

        if ($request->filled('priority')) {
            $data['priority'] = $request->priority;
        }

        if ($request->filled('admin_response')) {
            $data['admin_response'] = $request->admin_response;
        }

        if ($request->status === 'resolved') {
            $data['resolved_at'] = now();
        }

        $complaint->update($data);

        return redirect()->back()->with('success', 'Status keluhan berhasil diperbarui.');
    }

    /**
     * Display tenants management
     */
    public function tenants(Request $request)
    {
        $query = User::where('role', 'tenant');

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereHas('bookings', function($q) {
                    $q->where('status', 'confirmed');
                });
            } elseif ($request->status === 'inactive') {
                $query->whereDoesntHave('bookings', function($q) {
                    $q->where('status', 'confirmed');
                });
            }
        }

        // Apply room filter
        if ($request->filled('room')) {
            $query->whereHas('bookings', function($q) use ($request) {
                $q->where('room_id', $request->room)
                  ->where('status', 'confirmed');
            });
        }

        $tenants = $query->withCount(['bookings', 'bills', 'complaints'])
                         ->paginate(15);
        $rooms = Room::orderBy('room_number')->get();

        return view('admin.tenants', compact('tenants', 'rooms'));
    }

    /**
     * Display tenant details
     */
    public function tenantDetail(User $tenant)
    {
        $tenant->load(['bookings.room', 'bills.room', 'complaints.room']);
        
        return view('admin.tenant-detail', compact('tenant'));
    }

    /**
     * Delete tenant permanently
     */
    public function deleteTenant(User $tenant)
    {
        // Check if tenant has active bookings (confirmed status only)
        $activeBooking = $tenant->bookings()->where('status', 'confirmed')->first();
        if ($activeBooking) {
            return redirect()->route('admin.tenants')
                            ->with('error', 'Tidak dapat menghapus penghuni yang masih memiliki booking aktif. Silakan selesaikan booking terlebih dahulu dengan menandai booking sebagai "Selesai" di halaman Kelola Booking.');
        }

        // Check if tenant has unpaid bills
        $unpaidBills = $tenant->bills()->where('status', 'pending')->count();
        if ($unpaidBills > 0) {
            return redirect()->route('admin.tenants')
                            ->with('error', 'Tidak dapat menghapus penghuni yang masih memiliki tagihan belum dibayar.');
        }

        // Delete all related data first (cascade delete)
        $tenant->bookings()->delete();
        $tenant->bills()->delete();
        $tenant->complaints()->delete();
        
        // Finally delete the tenant
        $tenant->forceDelete();

        return redirect()->route('admin.tenants')
                        ->with('success', 'Penghuni dan semua data terkait berhasil dihapus secara permanen.');
    }

}
