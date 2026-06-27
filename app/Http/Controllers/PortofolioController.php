<?php

namespace App\Http\Controllers;

use App\Models\Portofolio;
use App\Models\KategoriPortofolio;
use App\Http\Requests\StorePortofolioRequest;
use App\Http\Requests\UpdatePortofolioRequest;
use App\DataTables\PortofolioDataTable;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class PortofolioController extends Controller
{
    public function index(PortofolioDataTable $dataTable)
    {
        return $dataTable->render('porto.index');
    }

    public function create()
    {
        $this->data['kategori_portofolios'] = KategoriPortofolio::orderBy('name_kategori_project_id')->get();
        $this->data['action'] = '/portofolio';

        return view('porto.form', $this->data);
    }

    public function store(StorePortofolioRequest $request, ImageService $imageService)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'portofolios/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image'] = $filename;
        }

        Portofolio::create($data);

        Cache::forget('all-data');

        return redirect('/portofolio')->with('success', 'Portofolio berhasil dibuat!');
    }

    public function edit(Portofolio $portofolio)
    {
        $this->data['kategori_portofolios'] = KategoriPortofolio::orderBy('name_kategori_project_id')->get();
        $this->data['portofolio_data'] = $portofolio;
        $this->data['action'] = '/portofolio/' . $portofolio->slug;

        return view('porto.form', $this->data);
    }

    public function update(UpdatePortofolioRequest $request, Portofolio $portofolio, ImageService $imageService)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($portofolio->image) {
                Storage::disk('public')->delete($portofolio->image);
            }

            $file = $request->file('image');
            $compressed = $imageService->compress($file);
            $filename = 'portofolios/' . uniqid() . '.jpg';
            Storage::disk('public')->put($filename, $compressed);
            $data['image'] = $filename;
        }

        $portofolio->update($data);

        Cache::forget('all-data');

        return redirect('/portofolio')->with('success', 'Portofolio berhasil diupdate!');
    }

    public function destroy(Portofolio $portofolio)
    {
        $portofolio->delete();

        return redirect('/portofolio')->with('success', 'Portofolio has been deleted!');
    }
}
