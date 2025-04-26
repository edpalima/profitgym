<?php

namespace App\Livewire;


use App\Models\Feedback;
use App\Models\Membership;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FeedbackForm extends Component
{
    public $message = '';
    public $rating = 5;
    public $membershipId = null;
    public $memberships = [];

    public function mount()
    {
        // Load memberships only
        $this->memberships = Membership::where('is_active', true)->get();
    }

    public function submit()
    {
        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to submit feedback.');
            return redirect()->route('login'); // <--- Safe redirect inside render
        }

        $this->validate([
            'membershipId' => 'required|exists:memberships,id',
            'message' => 'required|min:5',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to submit feedback.');
            return redirect()->route('login'); // Redirect inside submit
        }

        Feedback::create([
            'user_id' => Auth::id(),
            'membership_id' => $this->membershipId,
            'message' => $this->message,
            'rating' => $this->rating,
            'is_approved' => false,
        ]);

        session()->flash('success', 'Feedback submitted successfully!');
        $this->reset('message', 'rating', 'membershipId');
    }

    public function render()
    {
        return view('livewire.feedback-form');
    }
}
