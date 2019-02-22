<?php

namespace Phwebs\Activities\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Phwebs\Activities\Activities;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RecordsActivity
{
    use PivotEventTrait;

    public static function bootRecordsActivity()
    {
        static::getEventsToRecord()->each(function ($event) {
            return static::$event(function (Model $model, string $relationName = null, array $pivotIds = null) use ($event) {
                app(Activities::class)
                    ->activityTo($model)
                    ->recordActivity($model, $event, $relationName, $pivotIds);
            });
        });
    }

    protected static function getEventsToRecord(): Collection
    {
        return collect(config('activities.events'));
    }

    private function activities(): MorphMany
    {
        return $this->morphMany(config('activities.model'), 'subject');
    }
}