<?php

use App\Models\Post;
use Database\Seeders\PermissionSeeder;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Http\UploadedFile;


beforeEach(function () {
    $this->app->make(PermissionRegistrar::class)->registerPermissions();

    Event::listen(MigrationsEnded::class, function () {
        $this->artisan('db:seed', ['--class' => PermissionSeeder::class]);
    });
});

it('can store posts', function () {
    Storage::fake('s3');
    $file = UploadedFile::fake()->image('avatar.jpg');

    $post = Post::factory()->make([
        'blogPhoto' => $file,
    ]);

    adminLogin()->post('/post', $post->toArray())->assertStatus(201)->assertJson([
        'message' => "Post created successfully"
    ]);
});

test('only admins can upload post', function () {
    $post = Post::factory()->make();

    login()->post('/post', $post->toArray())
        ->assertStatus(403)
        ->assertJson(['message' => 'You are not authorized to publish post']);
});

it('can upload post images to aws s3', function () {
    Storage::fake('s3');

    $file = UploadedFile::fake()->image('avatar.jpg');

    $this->post('/upload-image', [
        'postImages' => $file,
    ]);

    Storage::disk('s3')->assertExists("postImages/" . $file->name);
});
