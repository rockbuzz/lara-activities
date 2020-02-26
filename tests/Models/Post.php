<?php

namespace Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Rockbuzz\LaraActivities\Traits\RecordsActivity;

class Post extends Model
{
    use RecordsActivity;

    protected $fillable = ['title', 'content', 'published_at'];

    protected $dates = ['published_at'];


}