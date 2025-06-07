<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\TrainerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerRatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['showLoginNotice']);
    }

    public function store(Request $request, Trainer $trainer)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'feedback' => 'nullable|string|max:1000',
            'recommend' => 'required|boolean'
        ]);

        $trainer->ratings()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'rating' => $request->rating,
                'feedback' => $request->feedback,
                'recommend' => $request->recommend
            ]
        );

        return back()->with('success', 'Thank you for your feedback!');
    }

    public function showLoginNotice(Request $request, Trainer $trainer)
    {
        return redirect()->route('login')->with('rate_redirect', [
            'trainer_id' => $trainer->id,
            'intended' => url()->previous()
        ]);
    }
}