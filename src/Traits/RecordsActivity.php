<?php

namespace Rockbuzz\LaraActivities\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Rockbuzz\LaraActivities\Activities;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RecordsActivity
{
    use PivotEventTrait;

    public $old = [];

    public $activitiesTableName = 'activities';

    public static function bootRecordsActivity()
    {
        static::getEventsToRecord()->each(function ($event) {
            return static::$event(function (
                Model $model,
                string $relationName = null,
                array $pivotIds = null
            ) use ($event) {
                if ('updated' === $event) {
                    $model->old = $model->getOriginal();
                }
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

    public function activities(): MorphMany
    {
        return $this->morphMany(config('activities.model'), 'subject');
    }
}
