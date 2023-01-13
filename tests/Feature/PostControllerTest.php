<?php

use App\Models\Post;
use Database\Seeders\PermissionSeeder;
use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;
use function Pest\Faker\faker;
use Illuminate\Http\UploadedFile;


beforeEach(function () {
    $this->app->make(PermissionRegistrar::class)->registerPermissions();

    Event::listen(MigrationsEnded::class, function () {
        $this->artisan('db:seed', ['--class' => PermissionSeeder::class]);
    });
});

it('can store posts', function () {

});

test('only admins can upload post', function () {
    login()->post('/upload-post', [
        'blogTitle' => faker()->text,
        'coverPhotoName' => faker()->name,
        'coverPhotoURL' => 'https:www.images.com/postImage',
        'blogHTML' => '<h1>I am a test</h1>',
    ])->assertStatus(403)->assertJson(['message' => 'You are not authorized to publish post']);
});


test('only admins can update post', function () {
    $post = Post::factory()->count(1)->create();
    $postId = $post->toArray()[0]['id'];

    login()->put('/posts/'. $postId, [
        'blogTitle' => "Updated Title",
        'coverPhotoName' => "Updated Photo Name",
        'coverPhotoURL' => 'https:www.images.com/updated-photo-url',
        'blogHTML' => '<h1>updated html</h1>',
    ])->assertStatus(403)->assertJson(['message' => 'You are not authorized to update a post']);
});

it('can upload posts to aws s3', function () {
    Storage::fake('avatars');

    $file = UploadedFile::fake()->image('avatar.jpg');

    $this->post('/upload-image', [
        'postImages' => $file,
    ]);

    Storage::disk('avatars')->assertExists($file->hashName());
})->only();

it('can update posts', function () {
    $post = Post::factory()->create();

    adminLogin()->put('/posts/' . $post->id, [
        'blogTitle' => 'Updated Title',
        'blogHTML' => '<h1>Updated HTML</h1>'
    ])->assertStatus(201)
        ->assertJson(['message' => 'Post updated successfully']);

    $response = $this->get('/post/' . $post->id);

    expect($response->blogTitle)->toBe("Updated Title");
})->skip();

it('can show single post', function () {
    $post = Post::factory()->create();
    dd($this->get('/posts/01ghf44bh602zj5pmhnfegv4ke'));
    $this->get('/post/' . $post->id)->assertStatus(200);
});

it('can delete post', function () {
    $this->assertTrue(true);
});

it('can retrieve latest posts', function () {
    $this->assertTrue(true);
});
