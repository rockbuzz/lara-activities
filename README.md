# Lara Activities

Lara Activities is a Laravel package that monitors activities for creating, editing, and deleting features, including manipulations of related tables.

<p><img src="https://github.com/rockbuzz/lara-activities/workflows/Main/badge.svg"/></p>


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

    //optional define activity table
    //public function __construct(array $attributes = [])
    //{
    //    parent::__construct($attributes);
    //
    //    $this->activityTable = 'post_activities';
    //}
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

You can also customize the lang
```bash
$ php artisan vendor:publish --provider="Rockbuzz\LaraActivities\ServiceProvider" --tag=lang
```

## License

The Lara Activities is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).