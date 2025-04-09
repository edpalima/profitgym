<?php

namespace App\Livewire;

use App\Models\Membership;
use Livewire\Component;

class Memberships extends Component
{
    public function render()
    {
        // Fetch active memberships from the database
        $memberships = Membership::where('is_active', true)->get();

        // Pass memberships data to the view
        return view('livewire.memberships', compact('memberships'));
    }
}
