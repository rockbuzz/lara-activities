<?php

namespace Phwebs\Activities\Traits;

use ReflectionClass;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RecordsActivity
{
    use PivotEventTrait;

    public static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivityToRecord() as $event) {
            static::$event(function ($model, $relationName = null, $pivotIds = null) use ($event) {
                $model->recordActivity(
                    $model->getActivityType($event, $relationName, $pivotIds)
                );
            });
        }
    }

    private function recordActivity(string $type)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $type
        ]);
    }

    private static function getActivityToRecord(): array
    {
        return config('laravel-activities.events');
    }

    private function activity(): MorphMany
    {
        return $this->morphMany(config('laravel-activities.model'), 'subject');
    }

    private function getActivityType($event, $relationName = null, $pivotIds = null): string
    {
        $identifier = config('laravel-activities.identifier.' . $event);
        $className = (new ReflectionClass($this))->getShortName();

        $string = config('laravel-activities.string.model');

        if ($relationName && $pivotIds) {
            $pivotIds = implode(',', $pivotIds);
            $string = config('laravel-activities.string.pivot');
        }

        return strtolower(strtr($string, [
            ':identifier' => $identifier,
            ':class' => $className,
            ':relation' => $relationName,
            ':values' => $pivotIds
        ]));
    }
}