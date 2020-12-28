<?php

namespace Tests;

use Tests\Stubs\{Post, User};
use Rockbuzz\LaraActivities\Models\Activity;

class RecordsActivityTest extends TestCase
{
    public function testItRecordsActivityWhenAPostIsCreated()
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

    public function testItRecordsActivityWhenAPostIsUpdated()
    {
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user.test@email.com',
            'password' => bcrypt('123456')
        ]);

        $this->actingAs($user);

        $publishedAtBefore = now();
        \DB::table('posts')->insert([
            'title' => 'Title Test',
            'content' => 'Content Test',
            'published_at' => $publishedAtBefore
        ]);

        $post = Post::whereTitle('Title Test')->firstOrFail();

        $publishedAtAfter = now()->addMinute();
        $post->update([
            'title' => 'Title Change',
            'published_at' => $publishedAtAfter
        ]);

        $this->assertDatabaseHas('activities', [
            'type' => 'atualizado-post',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'subject_id' => $post->id,
            'subject_type' => Post::class,
            'changes' => json_encode([
                'before' => ['title' => 'Title Test', 'published_at' => $publishedAtBefore->toDateTimeString()],
                'after' => ['title' => 'Title Change', 'published_at' => $publishedAtAfter->toDateTimeString()]
            ])
        ]);
    }

    public function testItRecordsActivityWhenAPostIsDeleted()
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

    public function testItRecordsActivityInOtherTable()
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

        $post->activitiesTableName = 'post_activities';

        $post->delete();

        $this->assertDatabaseHas('post_activities', [
            'type' => 'deletado-post',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'subject_id' => $post->id,
            'subject_type' => Post::class,
            'changes' => null
        ]);
    }
}
