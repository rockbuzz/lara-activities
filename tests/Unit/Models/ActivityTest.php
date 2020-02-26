<?php

namespace Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Rockbuzz\LaraActivities\Models\Activity;
use Tests\Models\Post;
use Tests\Models\User;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    public function testActivityCasts()
    {
        $post = Post::create([
            'title' => 'Title Test',
            'content' => 'Content Test'
        ]);

        $user = User::create([
            'name' => 'User Test',
            'email' => 'user.test@email.com',
            'password' => bcrypt('123456')
        ]);

        $activity = Activity::create([
            'type' => 'criado-post',
            'causer_id' => $user->id,
            'causer_type' => User::class,
            'subject_id' => $post->id,
            'subject_type' => Post::class,
            'changes' => null
        ]);

        $this->assertEquals(['id' => 'int', 'changes' => 'array'], $activity->getCasts());
    }

    public function testActivityHasSubjectAndCauser()
    {
        $post = Post::create([
            'title' => 'Title Test',
            'content' => 'Content Test'
        ]);

        $user = User::create([
            'name' => 'User Test',
            'email' => 'user.test@email.com',
            'password' => bcrypt('123456')
        ]);

        $activity = Activity::create([
            'type' => 'criado-post',
            'causer_id' => $user->id,
            'causer_type' => User::class,
            'subject_id' => $post->id,
            'subject_type' => Post::class,
            'changes' => null
        ]);

        $this->assertInstanceOf(MorphTo::class, $activity->subject());
        $this->assertEquals($post->id, $activity->subject->id);
        $this->assertInstanceOf(MorphTo::class, $activity->causer());
        $this->assertEquals($user->id, $activity->causer->id);
    }
}
