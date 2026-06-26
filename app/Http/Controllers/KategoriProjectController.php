<?php

namespace App\Http\Controllers;

use App\Models\KategoriProject;
use App\Http\Requests\StoreKategoriProjectRequest;
use App\Http\Requests\UpdateKategoriProjectRequest;
use App\DataTables\KategoriProjectDataTable;
use Illuminate\Support\Facades\Cache;

class KategoriProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KategoriProjectDataTable $dataTable)
    {
        return $dataTable->render('kategori_project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['action'] = "/kategori_project";
        return view('kategori_project.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKategoriProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKategoriProjectRequest $request)
    {
        $data = $request->all();

        KategoriProject::create($data);
        
        return redirect('/kategori_project')->with('success', 'Kategori Project berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriProject  $kategori_project
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriProject $kategori_project)
    {
        $this->data['kategori_projects'] = KategoriProject::all();
        $this->data['kategori_project_data'] = $kategori_project;
        $this->data['action'] = "/kategori_project/".$kategori_project->uuid;

        return view('kategori_project.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKategoriKategoriProjectRequest  $request
     * @param  \App\Models\KategoriProject  $kategori_project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKategoriProjectRequest $request, KategoriProject $kategori_project)
    {
        $data = $request->all();

        $kategori_project->update($data);

        return redirect('/kategori_project')->with('success', 'Kategori Project berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriProject  $kategori_project
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriProject $kategori_project)
    {
        $kategori_project->delete();
        
        return redirect('/kategori_project')->with('success', 'Kategori Project has been deleted!');
    }
}
