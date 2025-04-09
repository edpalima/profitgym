<?php

namespace App\Livewire;

use App\Models\Trainer;
use Livewire\Component;

class TrainerSection extends Component
{
    public function render()
    {
        $trainers = Trainer::all(); // You can apply filters if needed

        // Pass the data to the view
        return view('livewire.trainer-section', compact('trainers'));
    }
}
