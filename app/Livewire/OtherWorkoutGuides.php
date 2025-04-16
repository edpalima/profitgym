<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WorkoutGuide;

class OtherWorkoutGuides extends Component
{
    public $currentWorkoutId;
    public function render()
    {
        $guides = WorkoutGuide::where('id', '!=', $this->currentWorkoutId)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.other-workout-guides', [
            'guides' => $guides,
        ]);
    }
}
