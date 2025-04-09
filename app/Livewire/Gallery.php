<?php

namespace App\Livewire;

use Livewire\Component;

class Gallery extends Component
{
    public function render()
    {
        $galleries = \App\Models\Gallery::where('is_active', true)->get(); // Fetch active galleries

        // Pass the galleries data to the view
        return view('livewire.gallery', compact('galleries'));
    }
}
