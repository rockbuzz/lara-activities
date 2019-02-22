<?php

namespace Phwebs\Activities\Models;

//use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Phwebs\Activities\Contracts\Activity as ActivityInterface;

class Activity extends Model implements ActivityInterface
{
    protected $guarded = [];

    protected $with = ['subject'];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function causer(): MorphTo
    {
        return $this->morphTo();
    }
}
