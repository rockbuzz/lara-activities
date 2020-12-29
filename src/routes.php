<?php

Route::get(config('activities.routes.index.uri'), [
    'middleware' => config('activities.routes.index.middleware'),
    'as' => config('activities.routes.index.as'),
    'uses' => config('activities.routes.index.uses')
]);

Route::get(config('activities.routes.details.uri'), [
    'middleware' => config('activities.routes.details.middleware'),
    'as' => config('activities.routes.details.as'),
    'uses' => config('activities.routes.details.uses')
]);
