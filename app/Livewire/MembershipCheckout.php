<?php

namespace App\Livewire;

use App\Models\Membership;
use App\Models\UserMembership;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class MembershipCheckout extends Component
{
    use WithFileUploads;

    public $membership;
    public $payment_method = 'over_the_counter';
    public $image;
    public $description;

    public function mount($membershipId)
    {
        $this->membership = Membership::findOrFail($membershipId);
    }

    public function submit()
    {
        $this->validate([
            'payment_method' => 'required|in:over_the_counter,gcash',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        $userMembership = UserMembership::create([
            'user_id' => Auth::id(),
            'membership_id' => $this->membership->id,
            'start_date' => now(),
            'end_date' => now()->add($this->membership->duration_unit, $this->membership->duration_value),
            'status' => 'pending',
        ]);

        $paymentImage = $this->image ? $this->image->store('payment_receipts', 'public') : null;

        Payment::create([
            'type' => 'user_membership',
            'type_id' => $userMembership->id,
            'amount' => $this->membership->price,
            'payment_method' => $this->payment_method,
            'status' => 'pending',
            'image' => $paymentImage,
            'description' => $this->description,
        ]);

        session()->flash('success', 'Membership checkout submitted! Awaiting approval.');
        return redirect()->route('memberships.index');
    }

    public function render()
    {
        return view('livewire.membership-checkout');
    }
}
