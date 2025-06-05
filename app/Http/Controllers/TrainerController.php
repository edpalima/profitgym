<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::where('is_active', true)->get();

        return view('pages.trainers', compact('trainers'));
    }

   public function rateTrainer(Request $request, Trainer $trainer)
{
    $validated = $request->validate([
        'rating' => 'required|integer|between:1,5',
        'feedback' => 'nullable|string',
        'recommend' => 'required|boolean'
    ]);

    $trainer->ratings()->create([
        'user_id' => auth()->id(),
        'rating' => $validated['rating'],
        'feedback' => $validated['feedback'],
        'recommend' => $validated['recommend']
    ]);

    return redirect()->back()->with('success', 'Thank you for your feedback!');
}
}
