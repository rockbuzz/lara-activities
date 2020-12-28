<?php

namespace Tests;

use Tests\Stubs\{Post, User};
use Rockbuzz\LaraActivities\Models\Activity;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityTest extends TestCase
{
    /** @test */
    public function activity_has_casts()
    {
        $activity = new Activity();

        $this->assertEquals([
            'id' => 'int',
            'changes' => 'array'
        ], $activity->getCasts());
    }

    /** @test */
    public function activity_has_subject()
    {
        $post = factory(Post::class)->create();
        $activity = factory(Activity::class)->create([
            'subject_id' => $post->id,
            'subject_type' => Post::class
        ]);

        $this->assertInstanceOf(MorphTo::class, $activity->subject());
        $this->assertEquals($post->id, $activity->subject->id);
    }

    /** @test */
    public function activity_has_causer()
    {
        $user = factory(User::class)->create();
        $activity = factory(Activity::class)->create([
            'causer_id' => $user->id,
            'causer_type' => User::class
        ]);

        $this->assertInstanceOf(MorphTo::class, $activity->causer());
        $this->assertEquals($user->id, $activity->causer->id);
    }
}
