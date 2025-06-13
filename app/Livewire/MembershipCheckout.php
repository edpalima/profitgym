<?php

namespace App\Livewire;

use App\Models\Membership;
use App\Models\UserMembership;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class MembershipCheckout extends Component
{
    use WithFileUploads;

    public $membership;
    public $amount;
    public $paymentMethod = 'OVER_THE_COUNTER';
    public $image;
    public $referenceNo;
    public $startDate;
    public $terms = false;
    public $discount = 0;

    public $userHasMembership = false;
    public $userHasPendingMembership = false;

    public function mount($membershipId)
    {
        $this->discount = Auth::user()->getActiveMembership()->membership->price / 2;

        // dd($this->discount);
        $this->membership = Membership::findOrFail($membershipId);
        $this->amount = $this->membership->price - $this->discount;

        $this->userHasMembership = Auth::user()->hasMembership($this->membership->id);
        $this->userHasPendingMembership = Auth::user()->hasPendingMembership($this->membership->id);
    }

    public function submit()
    {
        $this->validate([
            'paymentMethod' => 'required|in:OVER_THE_COUNTER,GCASH',
            'image' => $this->paymentMethod === 'GCASH' ? 'required|image|max:2048' : 'nullable|image|max:2048',
            'referenceNo' => $this->paymentMethod === 'GCASH' ? 'required|string|max:100' : 'nullable|string|max:100',
            'startDate' => 'required|date|after_or_equal:today',
            'terms' => 'accepted',
        ]);

        $start = Carbon::parse($this->startDate);
        $end = $start->copy()->add($this->membership->duration_unit, $this->membership->duration_value);

        $userMembership = UserMembership::create([
            'user_id' => Auth::id(),
            'membership_id' => $this->membership->id,
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'PENDING',
            'upgrade' => true,
        ]);

        $paymentImage = $this->image ? $this->image->store('payment_receipts', 'public') : null;

        Payment::create([
            'type' => 'user_memberships',
            'type_id' => $userMembership->id,
            'amount' => $this->amount,
            'payment_method' => $this->paymentMethod,
            'reference_no' => $this->referenceNo,
            'status' => 'PENDING',
            'image' => $paymentImage,
        ]);

        session()->flash('success-member', 'Membership checkout submitted! Awaiting approval.');
        return redirect()->route('memberships.index');
    }

    public function render()
    {
        return view('livewire.membership-checkout');
    }
}
