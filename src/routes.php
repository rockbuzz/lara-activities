<?php

Route::get(config('activities.routes.index.uri'), [
    'middleware' => config('activities.routes.index.middleware'),
    'as' => config('activities.routes.index.as'),
    'uses' => config('activities.routes.index.uses')
]);
