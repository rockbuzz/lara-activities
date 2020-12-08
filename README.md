# Lara Activities

Lara Activities is a Laravel package that monitors activities for creating, editing, and deleting features, including manipulations of related tables.

[![Build Status](https://travis-ci.org/rockbuzz/lara-activities.svg?branch=master)](https://travis-ci.org/rockbuzz/lara-activities)

## Requirements

PHP: >=7.2.5

## Install

```bash
$ composer require rockbuzz/lara-activities
```
```bash
$ php artisan vendor:publish --provider="Rockbuzz\LaraActivities\ServiceProvider" --tag=migrations
```
```bash
$ php artisan migrate
```
## Usage

```php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rockbuzz\LaraActivities\Traits\RecordsActivity;

class Post extends Model
{
    use RecordsActivity;
}
```

## Configuration

```bash
$ php artisan vendor:publish --provider="Rockbuzz\LaraActivities\ServiceProvider" --tag=config
```
You can define the layout of the views
```php
'views' => [
    'layout' => 'layouts.admin'
]
```

You can override routes, controllers and middleware
```php
'routes' => [
    'index' => [
        'uri' => 'admin/activities',
        'as' => 'admin.activities',
        'middleware' => ['web', 'auth'],
        'uses' => 'Rockbuzz\LaraActivities\Controllers\ActivitiesController@index'
    ]
]
```

You can define which models will be searched in the activity table
```php
'subjects_class' => [
    'App\Post', 'App\Comment'
],

```

You can also customize the views
```bash
$ php artisan vendor:publish --provider="Rockbuzz\LaraActivities\ServiceProvider" --tag=views
```

## License

The Lara Activities is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).