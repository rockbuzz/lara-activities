<?php

namespace Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Rockbuzz\LaraActivities\Traits\RecordsActivity;

class Post extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'title',
        'content',
        'published_at',
        'public',
        'metadata->plans'
    ];

    public $casts = [
        'metadata' => 'array'
    ];

    protected $dates = [
        'published_at'
    ];

    public function setPublicAttribute($value): void
    {
        $metadata = is_array($this->metadata) ? $this->metadata : [];
        $this->attributes['metadata'] = json_encode(array_merge($metadata ?? [], ['public' => $value]));
    }

    public function getPublicAttribute(): bool
    {
        return (bool)$this->metadata['public'];
    }
}
