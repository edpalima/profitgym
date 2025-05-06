<?php

namespace App\Livewire;

use Livewire\Component;

class GallerySection extends Component
{
    public function render()
    {
        $galleries = \App\Models\Gallery::where('is_active', true)
            ->inRandomOrder()
            ->take(8)
            ->get(); // Fetch 8 random active galleries

        // Pass the galleries data to the view
        return view('livewire.gallery-section', compact('galleries'));
    }
}
