<?php

namespace App\Livewire;

use App\Models\WorkoutGuide;
use Livewire\Component;

class WorkoutGuideDetails extends Component
{
    public $workoutGuide;
    public function mount($id)
    {
        // Fetch the workout guide using the passed ID
        $this->workoutGuide = WorkoutGuide::findOrFail($id);
    }
    public function render()
    {
        return view('livewire.workout-guide-details');
    }
}
