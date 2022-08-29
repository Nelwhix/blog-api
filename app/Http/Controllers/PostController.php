<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->user()->hasRole('admin')) {
            return response([
                'message' => 'You are not authorized to publish post'
            ], 403);
        }

        $formFields = $request->validate([
            'blogTitle' => 'required',
            'coverPhotoName' => 'required',
            'blogHTML' => 'required',
        ]);

        $formFields['blogPhoto'] = $request->file('blogPhoto')->store('coverPhotos', 's3');
        Post::create($formFields);

        return response([
            'message' => 'Post created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Upload images on the quill editor to S3
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request) {

    }
}
