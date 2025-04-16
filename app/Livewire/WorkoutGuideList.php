<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WorkoutGuide;

class WorkoutGuideList extends Component
{
    public function render()
    {
        // Fetch all workout guides
        $workoutGuides = WorkoutGuide::where('is_active', true)->get();

        return view('livewire.workout-guide-list', compact('workoutGuides'));
    }
}
