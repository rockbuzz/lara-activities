<?php

namespace Phwebs\Activities\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Phwebs\Activities\Traits\RecordsActivity;

class Post extends Model
{
    use RecordsActivity;

    protected $fillable = ['title', 'content'];
}