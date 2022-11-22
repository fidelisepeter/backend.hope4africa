<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Http\Resources\BlogPostResource;

class BlogController extends Controller
{
    /**
     * Display a listing of post.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::all();
        return ResponseHelper::success('Post Retrived Successfully', BlogPostResource::collection($blogs), 201);
    }


    /**
     * Store a newly created post in storage.
     *
     * @param  \App\Http\Requests\BlogPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostRequest $request)
    {
        Log::alert($request->all());
        //Store thumbnail
        if ($files = $request->file('thumbnail')) {
            // Define upload path
            $destinationPath = public_path("/thumbnails/"); // upload path
            // Upload Orginal Image
            $thumbnail = date('YmdHis-') . strtolower(str_replace(' ', '-', $request->title)) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $thumbnail);
        }

        //Save Post and return with response
        $user = $request->user();
        Log::alert($user);
        $response = Blog::create([
            'title' => $request->title,
            'author_id' => $user->id,
            'content' => $request->content,
            'tags' => $request->tags,
            'thumbnail' => $thumbnail ?? '',
        ]);

        return ResponseHelper::success('Post Created Successfully', new BlogPostResource($response), 201);
    }

    /**
     * Display the specified post.
     *
     * @param  App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return ResponseHelper::success('Post Retrived Successfully', new BlogPostResource($blog), 201);
    }

    /**
     * Update the specified post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //Store thumbnail
        if ($files = $request->file('thumbnail')) {
            // Define upload path
            $destinationPath = public_path("/thumbnails/"); // upload path
            // Upload Orginal Image
            $thumbnail = date('YmdHis-') . strtolower(str_replace(' ', '-', $request->title)) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $thumbnail);
        }

        Log::alert(json_encode($request->all()));
        //Save Post and return with response
        $blog->update([
            'title' => $request->title ?? $blog->title,
            'content' => $request->content ?? $blog->content,
            'tags' => $request->tags ?? $blog->tags,
            'thumbnail' => $thumbnail ?? $blog->thumbnail,
        ]);
        return ResponseHelper::success('Post Updated Successfully', null);
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param  App\Models\Blog $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return ResponseHelper::success('Post Deleted Successfully', null);
    }
}
