<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Complaint;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DashboardController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display tenant dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'pending_bills' => Bill::where('user_id', $user->id)
                                 ->where('status', 'pending')
                                 ->count(),
            'overdue_bills' => Bill::where('user_id', $user->id)
                                  ->where('status', 'overdue')
                                  ->count(),
            'active_complaints' => Complaint::where('user_id', $user->id)
                                            ->whereIn('status', ['new', 'in_progress'])
                                            ->count(),
            'pending_payments' => Payment::where('user_id', $user->id)
                                        ->where('status', 'pending')
                                        ->count(),
        ];

        $recent_bills = Bill::where('user_id', $user->id)
                           ->orderBy('created_at', 'desc')
                           ->limit(5)
                           ->get();

        $recent_complaints = Complaint::where('user_id', $user->id)
                                     ->orderBy('created_at', 'desc')
                                     ->limit(5)
                                     ->get();

        return view('tenant.dashboard', compact('stats', 'recent_bills', 'recent_complaints'));
    }

    /**
     * Display bills page
     */
    public function bills()
    {
        $user = auth()->user();
        
        $bills = Bill::where('user_id', $user->id)
                    ->with('room')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('tenant.bills', compact('bills'));
    }

    /**
     * Display bill details
     */
    public function billDetail(Bill $bill)
    {
        $this->authorize('view', $bill);
        
        $bill->load(['room', 'payments']);
        
        return view('tenant.bill-detail', compact('bill'));
    }

    /**
     * Show payment form
     */
    public function showPaymentForm(Bill $bill)
    {
        $this->authorize('view', $bill);
        
        return view('tenant.payment-form', compact('bill'));
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, Bill $bill)
    {
        $this->authorize('view', $bill);
        
        $request->validate([
            'amount' => 'nullable',
            'payment_method' => 'required|in:bank_transfer,e_wallet',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'notes' => 'nullable|string|max:500',
        ]);

        // Force amount equals to bill total on server-side to avoid manipulation
        $payment = new Payment([
            'user_id' => auth()->id(),
            'bill_id' => $bill->id,
            'amount' => $bill->total_amount,
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');
            $payment->payment_proof = $path;
        }

        $payment->save();

        return redirect()->route('tenant.bills')
                        ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
    }

    /**
     * Display complaints page
     */
    public function complaints()
    {
        $user = auth()->user();
        
        $complaints = Complaint::where('user_id', $user->id)
                              ->with('room')
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);

        return view('tenant.complaints', compact('complaints'));
    }

    /**
     * Show complaint form
     */
    public function showComplaintForm()
    {
        $user = auth()->user();
        $rooms = $user->bookings()
                     ->where('status', 'confirmed')
                     ->with('room')
                     ->get()
                     ->pluck('room');

        return view('tenant.complaint-form', compact('rooms'));
    }

    /**
     * Process complaint submission
     */
    public function submitComplaint(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:100',
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'location' => 'nullable|string|max:200',
            'priority' => 'required|in:low,medium,high,urgent',
            'images.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        $complaint = new Complaint([
            'user_id' => auth()->id(),
            'room_id' => $request->room_id,
            'category' => $request->category,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'priority' => $request->priority,
            'status' => 'new',
        ]);

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('complaint-images', 'public');
                $images[] = $path;
            }
            $complaint->images = $images;
        }

        $complaint->save();

        return redirect()->route('tenant.complaints')
                        ->with('success', 'Komplain berhasil diajukan. Admin akan segera menindaklanjuti.');
    }

    /**
     * Display complaint details
     */
    public function complaintDetail(Complaint $complaint)
    {
        $this->authorize('view', $complaint);
        
        $complaint->load('room');
        
        return view('tenant.complaint-detail', compact('complaint'));
    }
}
