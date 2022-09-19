<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->take(10)->get();

        return response([
            'blogPosts' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->user()->hasRole('Admin')) {
            return response([
                'message' => 'You are not authorized to publish post'
            ], 403);
        }

        $formFields = $request->validate([
            'blogTitle' => 'required',
            'coverPhotoName' => 'required',
            'blogHTML' => 'required',
        ]);

        $file = $request->file('blogPhoto');
        $fileName = $file->getClientOriginalName();
        $file->storeAs('coverPhotos/', $fileName, 's3');

        $url = Storage::disk('s3')->url('coverPhotos/'. $fileName);

        $formFields['coverPhotoURL'] = $url;


        Post::create($formFields);

        return response([
            'message' => 'Post created successfully'
        ], 201);
    }

    /**
     * Upload images on the quill editor to S3
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request) {
        // upload the file to s3
        $file = $request->file('postImages');
        $fileName = $file->getClientOriginalName(). mt_rand(1, 1000000);
        $file->storeAs('postImages/', $fileName, 's3');

        // get the file link
        $url = Storage::disk('s3')->url('postImages/'. $fileName);

        return response([
            'url' => $url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if ($post === null) {
            return response([
                'message' => 'no post matching this ID was found'
            ], 404);
        }

        return response([
            'post' => $post
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
