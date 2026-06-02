<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use App\Http\Requests\StoreSertifikatRequest;
use App\Http\Requests\UpdateSertifikatRequest;
use App\DataTables\SertifikatDataTable;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SertifikatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SertifikatDataTable $dataTable)
    {
        return $dataTable->render('sertifikat.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $this->data['Sertifikats'] = Sertifikat::all();

        $this->data['action'] = "/sertifikat";
        return view('sertifikat.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSertifikatRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSertifikatRequest $request, ImageService $imageService)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // proses compress
            $compressed = $imageService->compress($file);

            // nama file unik
            $filename = 'sertifikats/' . uniqid() . '.jpg';

            // simpan ke storage
            Storage::disk('public')->put($filename, $compressed);

            $data['image'] = $filename;
        }

        Sertifikat::create($data);

        Cache::forget('all-data');

        return redirect('/sertifikat')->with('success', 'Sertifikat berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return \Illuminate\Http\Response
     */
    public function edit(Sertifikat $sertifikat)
    {
        $this->data['sertifikats'] = Sertifikat::all();

        $this->data['sertifikat_data'] = $sertifikat;
        $this->data['action'] = "/sertifikat/".$sertifikat->slug;
        return view('sertifikat.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSertifikatRequest  $request
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSertifikatRequest $request, Sertifikat $sertifikat, ImageService $imageService)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            // hapus gambar lama (biar gak numpuk)
            if ($sertifikat->image) {
                Storage::disk('public')->delete($sertifikat->image);
            }

            $file = $request->file('image');

            $compressed = $imageService->compress($file);

            $filename = 'sertifikats/' . uniqid() . '.jpg';

            Storage::disk('public')->put($filename, $compressed);

            $data['image'] = $filename;
        }

        $sertifikat->update($data);

        Cache::forget('all-data');

        return redirect('/sertifikat')->with('success', 'Sertifikat berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sertifikat  $sertifikat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sertifikat $sertifikat)
    {
        $sertifikat->delete();
        return redirect('/sertifikat')->with('success', 'Permission Group has been deleted!');
    }
}
