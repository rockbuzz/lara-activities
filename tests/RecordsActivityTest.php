<?php

namespace Tests;

use Tests\Models\{Post, User};
use Illuminate\Support\Facades\DB;
use Rockbuzz\LaraActivities\Models\Activity;

class RecordsActivityTest extends TestCase
{
    /** @test */
    public function it_records_activity_when_a_post_is_created()
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
            'type' => 'created-post',
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

    /** @test */
    public function it_records_activity_when_a_post_is_updated()
    {
        $this->knownDate();

        $user = User::create([
            'name' => 'User Test',
            'email' => 'user.test@email.com',
            'password' => bcrypt('123456')
        ]);

        $this->actingAs($user);

        $publishedAtBefore = now();
        DB::table('posts')->insert([
            'title' => 'Title Test',
            'content' => 'Content Test',
            'published_at' => $publishedAtBefore,
            'metadata' => json_encode([
                'public' => false,
                'plans' => $plansBefore = [1, 2, 5]
            ])
        ]);

        $post = Post::whereTitle('Title Test')->firstOrFail();

        $publishedAtAfter = now()->addMinute();
        $post->update([
            'title' => 'Title Change',
            'published_at' => $publishedAtAfter,
            'public' => true,
            'metadata->plans' => $plansAfter = [6, 4, 9]
        ]);

        $this->assertDatabaseHas('activities', [
            'type' => 'updated-post',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'subject_id' => $post->id,
            'subject_type' => Post::class,
            'changes' => json_encode([
                'before' => [
                    'title' => 'Title Test',
                    'published_at' => $publishedAtBefore->seconds(0)->toJSON(),
                    'metadata' => [
                        'public' => false,
                        'plans' => $plansBefore
                    ]
                ],
                'after' => [
                    'title' => 'Title Change',
                    'published_at' => $publishedAtAfter->seconds(0)->toJSON(),
                    'metadata' => [
                        'public' => true,
                        'plans' => $plansAfter
                    ]
                ]
            ])
        ]);
    }

    /** @test */
    public function it_records_activity_when_a_post_is_deleted()
    {
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user.test@email.com',
            'password' => bcrypt('123456')
        ]);

        $this->actingAs($user);

        DB::table('posts')->insert([
            'title' => 'Title Test',
            'content' => 'Content Test'
        ]);

        $post = Post::whereTitle('Title Test')->firstOrFail();

        $post->delete();

        $this->assertDatabaseHas('activities', [
            'type' => 'deleted-post',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'subject_id' => $post->id,
            'subject_type' => Post::class,
            'changes' => null
        ]);
    }

    /** @test */
    public function it_records_activity_in_other_table()
    {
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user.test@email.com',
            'password' => bcrypt('123456')
        ]);

        $this->actingAs($user);

        DB::table('posts')->insert([
            'title' => 'Title Test',
            'content' => 'Content Test'
        ]);

        $post = Post::whereTitle('Title Test')->firstOrFail();

        $post->activityTable = 'post_activities';

        $post->delete();

        $this->assertDatabaseMissing('activities', [
            'type' => 'deleted-post',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'subject_id' => $post->id,
            'subject_type' => Post::class,
            'changes' => null
        ]);

        $this->assertDatabaseHas('post_activities', [
            'type' => 'deleted-post',
            'causer_type' => User::class,
            'causer_id' => auth()->id(),
            'subject_id' => $post->id,
            'subject_type' => Post::class,
            'changes' => null
        ]);
    }
}
