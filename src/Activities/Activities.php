<?php

namespace Phwebs\Activities;

use ReflectionClass;
use Exception;
use Illuminate\Auth\AuthManager;
use Illuminate\Database\Eloquent\Model;
use Phwebs\Activities\Contracts\Activity as ActivityInterface;

class Activities
{
    protected $auth;

    protected $authDriver;

    protected $activity;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;

        $this->authDriver = config('activities.auth_driver') ?? $this->auth->getDefaultDriver();
    }

    public function activityTo(Model $model)
    {
        $this->getActivity()->subject()->associate($model);

        return $this;
    }

    public function causedBy($modelOrId)
    {
        if ($modelOrId === null) {
            return $this;
        }

        $model = $this->normalizeCauser($modelOrId);

        $this->getActivity()->causer()->associate($model);

        return $this;
    }

    public function recordActivity(Model $model, string $event, string $relationName = null, array $pivotIds = null)
    {
        $activity = $this->activity;

        $activity->type = $this->getType($model, $event, $relationName, $pivotIds);

        $activity->save();

        $this->activity = null;

        return $activity;
    }

    protected function getType(Model $model, string $event, string $relationName = null, array $pivotIds = null): string
    {
        $identifier = config('activities.identifier.' . $event);
        $className = (new ReflectionClass($model))->getShortName();

        $string = config('activities.string.model');

        if ($relationName && $pivotIds) {
            $pivotIds = implode(',', $pivotIds);
            $string = config('activities.string.pivot');
        }

        return strtolower(strtr($string, [
            ':identifier' => $identifier,
            ':class' => $className,
            ':relation' => $relationName,
            ':values' => $pivotIds
        ]));
    }

    protected function normalizeCauser($modelOrId): Model
    {
        if ($modelOrId instanceof Model) {
            return $modelOrId;
        }

        $model = $this->auth->guard($this->authDriver)->getProvider()->retrieveById($modelOrId);

        if ($model) {
            return $model;
        }

        throw new Exception('Not Determinet User');
    }

    protected function getActivity(): ActivityInterface
    {
        if (!$this->activity instanceof ActivityInterface) {
            $className = config('activities.model');
            $this->activity = new $className;

            $this->causedBy($this->auth->guard($this->authDriver)->user());
        }

        return $this->activity;
    }
}