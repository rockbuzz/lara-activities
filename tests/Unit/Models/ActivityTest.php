<?php

namespace Tests\Unit\Models;

use Rockbuzz\LaraActivities\Models\Activity;
use Tests\Models\Post;
use Tests\Models\User;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    /**
     * @test
     */
    public function itRecordsActivityWhenAPostIsCreated()
    {
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user.test@email.com',
            'password' => bcrypt('123456')
        ]);

        $this->actingAs($user);

        $post = Post::create([
            'title' => 'Title Test',
            'content' => 'Content Test'
        ]);

        $this->assertDatabaseHas('activities', [
            'type' => 'criado-post',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'subject_id' => $post->id,
            'subject_type' => Post::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $post->id);
    }
}
