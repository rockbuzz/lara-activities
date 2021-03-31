<?php

namespace Rockbuzz\LaraActivities\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rockbuzz\LaraActivities\Contracts\Activity as ActivityInterface;

class Activity extends Model implements ActivityInterface
{
    protected $guarded = [];

    protected $with = [
        'subject'
    ];

    protected $casts = [
        'changes' => 'array'
    ];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }
}
