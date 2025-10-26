<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show profile form
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.form', compact('user'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'occupation' => 'required|string|max:100',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_card_number' => 'required|string|max:20',
            'id_card_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'occupation' => $request->occupation,
            'emergency_contact_name' => $request->emergency_contact_name,
            'emergency_contact_phone' => $request->emergency_contact_phone,
            'id_card_number' => $request->id_card_number,
        ];

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $data['profile_picture'] = $path;
        }

        // Handle ID card file upload
        if ($request->hasFile('id_card_file')) {
            if ($user->id_card_file) {
                Storage::disk('public')->delete($user->id_card_file);
            }
            $path = $request->file('id_card_file')->store('id-cards', 'public');
            $data['id_card_file'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.show')
                        ->with('success', 'Data diri berhasil diperbarui.');
    }
}
