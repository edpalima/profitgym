<?php

namespace App\Http\Controllers;

use App\Models\WorkoutGuide;
use Illuminate\Http\Request;

class WorkoutGuideController extends Controller
{
    public function show($id)
    {
        $workoutGuide = WorkoutGuide::where('id', $id)->where('is_active', true)->first();
        if (!$workoutGuide) {
            return redirect('/');
        }
        return view('pages.workout-guide-show', compact('workoutGuide'));
    }
}
