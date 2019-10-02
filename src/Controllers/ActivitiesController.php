<?php

namespace Rockbuzz\LaraActivities\Controllers;

use Illuminate\Routing\Controller;
use Rockbuzz\LaraActivities\Models\Activity;

class ActivitiesController extends Controller
{
    public function index()
    {
        $builder = Activity::latest();

        if ($search = request('search')) {
            $builder = $builder->whereHasMorph(
                'subject',
                config('activities.subjects_class'),
                function ($query) use ($search) {
                    $query->where('id', $search);
                }
            );           
        }        

        $activities = $builder->paginate(50);

        return view('activities::index', compact('activities'));
    }
}
