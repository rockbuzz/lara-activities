<?php

Route::get(config('activities.routes.index'),[
    'middleware' => ['auth', 'api'],
    'uses' => 'Rockbuzz\LaraActivities\Controllers\ActivitiesController'
]);