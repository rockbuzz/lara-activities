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
            'subject_type' => Post::class,
            'changes' => null
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $post->id);
        $this->assertNull($activity->changes);
    }

    /**
     * @test
     */
    public function itRecordsActivityWhenAPostIsUpdated()
    {
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user.test@email.com',
            'password' => bcrypt('123456')
        ]);

        $this->actingAs($user);

        \DB::table('posts')->insert([
            'title' => 'Title Test',
            'content' => 'Content Test'
        ]);

        $post = Post::whereTitle('Title Test')->firstOrFail();

        $post->update([
            'title' => 'Title Change'
        ]);

        $this->assertDatabaseHas('activities', [
            'type' => 'atualizado-post',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'subject_id' => $post->id,
            'subject_type' => Post::class,
            'changes' => json_encode([
                'before' => ['title' => 'Title Test'],
                'after' => ['title' => 'Title Change']
            ])
        ]);
    }

    /**
     * @test
     */
    public function itRecordsActivityWhenAPostIsDeleted()
    {
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user.test@email.com',
            'password' => bcrypt('123456')
        ]);

        $this->actingAs($user);

        \DB::table('posts')->insert([
            'title' => 'Title Test',
            'content' => 'Content Test'
        ]);

        $post = Post::whereTitle('Title Test')->firstOrFail();

        $post->delete();

        $this->assertDatabaseHas('activities', [
            'type' => 'deletado-post',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'subject_id' => $post->id,
            'subject_type' => Post::class,
            'changes' => null
        ]);
    }
}
