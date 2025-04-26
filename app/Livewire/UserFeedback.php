<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Feedback;

class UserFeedback extends Component
{
    public $feedbacks;

    public function mount()
    {
        $this->loadFeedbacks();
    }

    public function loadFeedbacks()
    {
        $this->feedbacks = Feedback::with('membership')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function delete($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        $this->loadFeedbacks();

        session()->flash('message', 'Feedback deleted successfully.');
    }

    public function render()
    {
        return view('livewire.user-feedback');
    }
}
