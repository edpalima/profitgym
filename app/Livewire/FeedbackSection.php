<?php

namespace App\Livewire;

use App\Models\Feedback;
use Livewire\Component;

class FeedbackSection extends Component
{
    public $feedbacks;

    public function mount()
    {
        $this->feedbacks = Feedback::where('is_approved', true)->latest()->take(10)->get();
    }

    public function render()
    {
        return view('livewire.feedback-section');
    }
}
