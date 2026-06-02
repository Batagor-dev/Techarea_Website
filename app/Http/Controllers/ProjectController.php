<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\DataTables\ProjectDataTable;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectDataTable $dataTable)
    {
        return $dataTable->render('project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->data['projects'] = Project::all();

        $this->data['action'] = "/project";
        return view('project.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request, ImageService $imageService)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // proses compress
            $compressed = $imageService->compress($file);

            // nama file unik
            $filename = 'projects/' . uniqid() . '.jpg';

            // simpan ke storage
            Storage::disk('public')->put($filename, $compressed);

            $data['image'] = $filename;
        }

        Project::create($data);
        
        Cache::forget('all-data');

        return redirect('/project')->with('success', 'Project berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $this->data['projects'] = Project::all();

        $this->data['project_data'] = $project;
        $this->data['action'] = "/project/".$project->slug;
        return view('project.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project, ImageService $imageService)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            // hapus gambar lama (biar gak numpuk)
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }

            $file = $request->file('image');

            $compressed = $imageService->compress($file);

            $filename = 'projects/' . uniqid() . '.jpg';

            Storage::disk('public')->put($filename, $compressed);

            $data['image'] = $filename;
        }

        $project->update($data);

        Cache::forget('all-data');

        return redirect('/project')->with('success', 'Project berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect('/project')->with('success', 'Permission Group has been deleted!');
    }
}
