<?php

namespace Rockbuzz\LaraActivities\Models;

use DateTimeInterface;
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

    public function prune(DateTimeInterface $before, int $chunkSize = 1000)
    {
        $query = self::query()->where('created_at', '<', $before);

        $totalDeleted = 0;

        do {
            $deleted = $query->take($chunkSize)->delete();

            $totalDeleted += $deleted;
        } while ($deleted !== 0);

        return $totalDeleted;
    }
}
