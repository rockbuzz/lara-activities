<?php

namespace Rockbuzz\LaraActivities\Controllers;

use Illuminate\Routing\Controller;
use Rockbuzz\LaraActivities\Models\Activity;

class ActivitiesController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->paginate(30);

        if ($type = request('type')) {
            $activities = Activity::where('type', 'like', "%{$type}%")
                ->latest()
                ->paginate(30);
        }

        return view('activities::index', compact('activities'));
    }
}
