<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return ResponseHelper::success('Projects Retrived Successfully', ProjectResource::collection($projects), 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        if ($files = $request->file('thumbnail')) {
            // Define upload path
            $destinationPath = public_path("/thumbnails/"); // upload path
            // Upload Orginal Image
            $thumbnail = date('YmdHis-') . strtolower(str_replace(' ', '-', $request->title)) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $thumbnail);
        }

        //Save Project and return with response
       
        $response = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnail ?? '',
        ]);

        return ResponseHelper::success('Project Created Successfully', new ProjectResource($response), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return ResponseHelper::success('Project Retrived Successfully', new ProjectResource($project), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
         //Store thumbnail
         if ($files = $request->file('thumbnail')) {
            // Define upload path
            $destinationPath = public_path("/thumbnails/"); // upload path
            // Upload Orginal Image
            $thumbnail = date('YmdHis-') . strtolower(str_replace(' ', '-', $request->title)) . "." . $files->getClientOriginalExtension();
            $files->move($destinationPath, $thumbnail);
        }

        //Save Post and return with response
        $project->update([
            'title' => $request->title ?? $project->title,
            'description' => $request->description ?? $project->description,
            'thumbnail' => $thumbnail ?? $project->thumbnail,
        ]);
        return ResponseHelper::success('Project Updated Successfully', null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return ResponseHelper::success('Project Deleted Successfully', null);
    }
}
