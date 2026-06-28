<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Http\Requests\StorePerusahaanRequest;
use App\Http\Requests\UpdatePerusahaanRequest;
use App\DataTables\PerusahaanDataTable;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PerusahaanDataTable $dataTable)
    {
        $hasPerusahaan = Perusahaan::exists();

        return $dataTable->render('perusahaan.index', compact('hasPerusahaan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['action'] = "/perusahaan";
        return view('perusahaan.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePerusahaanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerusahaanRequest $request, ImageService $imageService)
    {
        $data = $request->all();

       if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            $compressed = $imageService->compress($file);

            $filename = 'perusahaan/' . uniqid() . '.jpg';

            Storage::disk('public')->put($filename, $compressed);

            $data['logo'] = $filename;
        }


        Perusahaan::create($data);
        
        return redirect('/perusahaan')->with('success', 'Perusahaan berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Perusahaan $perusahaan)
    {
        $this->data['perusahaans'] = Perusahaan::all();
        $this->data['perusahaan_data'] = $perusahaan;
        $this->data['action'] = "/perusahaan/".$perusahaan->uuid;

        return view('perusahaan.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePerusahaanRequest  $request
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerusahaanRequest $request, Perusahaan $perusahaan, ImageService $imageService)
    {
        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($perusahaan->logo && Storage::disk('public')->exists($perusahaan->logo)) {
                Storage::disk('public')->delete($perusahaan->logo);
            }

            $file = $request->file('logo');

            $compressed = $imageService->compress($file);

            $filename = 'perusahaan/' . uniqid() . '.jpg';

            Storage::disk('public')->put($filename, $compressed);

            $data['logo'] = $filename;
        }

        $perusahaan->update($data);

        return redirect('/perusahaan')->with('success', 'Perusahaan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perusahaan  $perusahaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perusahaan $perusahaan)
    {
        $perusahaan->delete();
        
        return redirect('/perusahaan')->with('success', 'Perusahaan has been deleted!');
    }
}
