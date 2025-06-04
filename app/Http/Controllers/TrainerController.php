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

    public function rate(Request $request, Trainer $trainer)
{
    $request->validate([
        'rating' => 'required|integer|between:1,5',
        'feedback' => 'nullable|string|max:500',
        'recommend' => 'required|boolean'
    ]);

    // Create a new rating/feedback record (you'll need to adjust this based on your database structure)
    $trainer->ratings()->create([
        'user_id' => auth()->id(),
        'rating' => $request->rating,
        'feedback' => $request->feedback,
        'recommend' => $request->recommend
    ]);

    return back()->with('success', 'Thank you for your feedback!');
}
}
