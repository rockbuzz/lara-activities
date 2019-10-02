<?php

return [

    //to search by subject id
    'subjects_class' => [
        //App\Post
    ],

    /*
    |--------------------------------------------------------------------------
    | Activity Model
    |--------------------------------------------------------------------------
    |
    |  This value is the activity model of your application. This value is used
    |  to create the morph relationship between the activity table and the template
    |  that will record an activity, change this value if you need to override this model.
    |
    |  Default: \Phwebs\Activities\Models\Activity::class
    |
    */

    'model' => \Rockbuzz\LaraActivities\Models\Activity::class,

    'auth_driver' => null,

    /*
    |--------------------------------------------------------------------------
    | Activity Events
    |--------------------------------------------------------------------------
    |
    |  This value is an array with the events that will be monitored by the activities
    |  of the model that implement
    |  trait \Phwebs\Activities\Traits\RecordsActivity::class.
    |
    |  Model Values: retrieved, created, updated, saved, deleted, restored
    |  Related Pivot Values: pivotAttached, pivotDetached, pivotUpdated
    |
    */

    'events' => [
        'created',
        'updated',
        'deleted',
        'pivotAttached',
        'pivotDetached',
        'pivotUpdated'
    ],

    /*
    |--------------------------------------------------------------------------
    | Activity Identifier
    |--------------------------------------------------------------------------
    |
    |  This value is an array, where the key is the event and the value is the
    |  identifier that will be added to the string stored in the database.
    |
    */

    'identifier' => [
        'retrieved' => 'recuperado',
        'created' => 'criado',
        'updated' => 'atualizado',
        'saved' => 'salvo',
        'deleted' => 'deletado',
        'restored' => 'restaurado',
        'pivotAttached' => 'anexado',
        'pivotDetached' => 'desanexado',
        'pivotUpdated' => 'atualizado Anexo'
    ],

    /*
    |--------------------------------------------------------------------------
    | Activity String
    |--------------------------------------------------------------------------
    |
    |  This value is a simple query that will be used to assemble the string with
    |  the information in the database.
    |
    |  :identifier = will receive the value of the identifier;
    |  :class = will receive the name of the model that triggered the event;
    |  :relation = will receive the name of the method of relationship with the model;
    |  :ids = will receive the ids that were bound to the model in the pivot table
    |
    */

    'string' => [
        'model' => ':identifier-:class',
        'pivot' => ':identifier-:relation=:ids'
    ],

    'routes' => [
        'index' => [
            'uri' => 'admin/atividades',
            'as' => 'admin.activities',
            'middleware' => ['web', 'auth'],
            'uses' => 'Rockbuzz\LaraActivities\Controllers\ActivitiesController@index'
        ]
    ],
    'views' => [
        'layout' => 'layouts.admin'
    ]
];
