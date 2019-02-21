<?php

namespace Phwebs\Activities\Test\Unit\Models;

use Phwebs\Activities\Models\Activity;
use Phwebs\Activities\Test\Models\Post;
use Phwebs\Activities\Test\Models\User;
use Phwebs\Activities\Test\TestCase;

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
            'user_id' => auth()->id(),
            'subject_id' => $post->id,
            'subject_type' => Post::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $post->id);
    }
}
