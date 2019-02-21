<?php

namespace Phwebs\Activities\Models;

//use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    protected $guarded = [];

    protected $with = ['subject'];

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

//    public function user(): BelongsTo
//    {
//        return $this->belongsTo(User::class);
//    }
}
