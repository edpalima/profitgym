<?php

namespace App\Livewire;

use App\Models\Membership;
use Livewire\Component;

class Memberships extends Component
{
    public function render()
    {
        $memberships = Membership::where('is_active', true)
            ->where('walk_in_only', false)
            ->get();

        return view('livewire.memberships', compact('memberships'));
    }
}
