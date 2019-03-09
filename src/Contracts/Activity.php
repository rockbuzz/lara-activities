<?php

namespace Rockbuzz\LaraActivities\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphTo;

interface Activity
{
    public function subject(): MorphTo;

    public function causer(): MorphTo;
}
