# Lara Activities

Lara Activities is a Laravel 5.5 or higher package that monitors activities for creating, editing, and deleting features, including manipulations of related tables.

[![Build Status](https://travis-ci.org/rockbuzz/lara-activities.svg?branch=master)](https://travis-ci.org/rockbuzz/lara-activities)

## Requirements

PHP: >=7.1

## Install

```bash
$ composer require rockbuzz/lara-activities
```

## Configuration

```bash
$ php artisan vendor:publish --provider="Rockbuzz\LaraActivities\ServiceProvider" --tag=config
```
```php
'routes' => [
    'index' => [
        'uri' => 'admin/atividades',
        'as' => 'admin.activities',
        'middleware' => ['web', 'auth'],
        'uses' => 'Rockbuzz\LaraActivities\Controllers\ActivitiesController@index'
    ]
]
```

## Optional

```bash
$ php artisan vendor:publish --provider="Rockbuzz\LaraActivities\ServiceProvider" --tag=views
```

## Usage

```bash
$ php artisan vendor:publish --provider="Rockbuzz\LaraActivities\ServiceProvider" --tag=migrations
$ php artisan migrate
```

```php
class Post extends Model
{
    use Rockbuzz\LaraActivities\Traits\RecordsActivity;
}
```

config in activities.php to search by subject id
```php
'subjects_class' => [
    'App\Post', 'App\Comment'
],
```

## License

The Lara Activities is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).