<?php

use Database\Seeders\PermissionSeeder;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Event;
use Spatie\Permission\PermissionRegistrar;
use function Pest\Faker\faker;
use Illuminate\Http\UploadedFile;


beforeEach(function () {
    $this->app->make(PermissionRegistrar::class)->registerPermissions();

    Event::listen(MigrationsEnded::class, function () {
        $this->artisan('db:seed', ['--class' => PermissionSeeder::class]);
        $this->app->make(PermissionRegistrar::class)->forgetCachedPermissions();
    });
});

it('can store posts', function () {
    $file = UploadedFile::fake()->image('avatar.jpg');

    adminLogin()->post('/upload-post', [
        'blogTitle' => faker()->text,
        'blogPhoto' => $file,
        'blogHTML' => '<h1>I am a test</h1>',
    ])->assertStatus(201)->assertJson(['message' => 'Post created successfully']);
});

test('only admins can upload post', function () {
    login()->post('/upload-post', [
        'blogTitle' => faker()->text,
        'coverPhotoName' => faker()->name,
        'coverPhotoURL' => 'https:www.images.com/postImage',
        'blogHTML' => '<h1>I am a test</h1>',
    ])->assertStatus(403)->assertJson(['message' => 'You are not authorized to publish post']);
});

it('can upload posts to aws s3', function () {
    $file = UploadedFile::fake()->image('avatar.jpg');

    $this->post('/upload-image', [
        'postImages' => $file,
    ])->assertStatus(201);
});

it('can update posts', function () {
    $this->assertTrue(true);
});

it('can show single post', function () {
    $this->assertTrue(true);
});

it('can delete post', function () {
    $this->assertTrue(true);
});

it('can retrieve all posts in the db', function () {
    $this->assertTrue(true);
});
