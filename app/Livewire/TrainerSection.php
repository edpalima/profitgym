<?php

namespace App\Livewire;

use App\Models\Trainer;
use Livewire\Component;

class TrainerSection extends Component
{
    public function render()
    {
        $trainers = Trainer::where('is_active', true)->get();

        // Pass the data to the view
        return view('livewire.trainer-section', compact('trainers'));
    }
}