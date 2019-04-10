<?php

namespace Rockbuzz\LaraActivities\Controllers;

use App\Http\Controllers\Controller;
use Rockbuzz\LaraActivities\Models\Activity;

class ActivitiesController extends Controller
{
    public function index()
    {
        $activities = Activity::paginate(20);

        return view('activities::index', compact('activities'));
    }
}
