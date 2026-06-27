<?php

namespace App\Http\Controllers;

use App\Models\KategoriPortofolio;
use App\Http\Requests\StoreKategoriPortofolioRequest;
use App\Http\Requests\UpdateKategoriPortofolioRequest;
use App\DataTables\KategoriPortofolioDataTable;
use Illuminate\Support\Facades\Cache;

class KategoriPortofolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(KategoriPortofolioDataTable $dataTable)
    {
        return $dataTable->render('kategori_portofolio.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['action'] = "/kategori_portofolio";
        return view('kategori_portofolio.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKategoriPortofolioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKategoriPortofolioRequest $request)
    {
        $data = $request->validated();
        KategoriPortofolio::create($data);

        Cache::forget('all-data');

        return redirect('/kategori_portofolio')->with('success', 'Kategori Portofolio berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriPortofolio  $kategori_portofolio
     * @return \Illuminate\Http\Response
     */
    public function edit(KategoriPortofolio $kategori_portofolio)
    {
        $this->data['kategori_portoflios'] = KategoriPortofolio::all();
        $this->data['kategori_portofolio_data'] = $kategori_portofolio;
        $this->data['action'] = "/kategori_portofolio/".$kategori_portofolio->uuid;

        return view('kategori_portofolio.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKategoriPortofolioRequest  $request
     * @param  \App\Models\KategoriPortofolio  $kategori_portofolio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKategoriPortofolioRequest $request, KategoriPortofolio $kategori_portofolio)
    {
        $data = $request->validated();

        $kategori_portofolio->update($data);

        Cache::forget('all-data');

        return redirect('/kategori_portofolio')->with('success', 'Kategori Portofolio berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriPortofolio  $kategori_portofolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(KategoriPortofolio $kategori_portofolio)
    {
        $kategori_portofolio->delete();

        return redirect('/kategori_portofolio')->with('success', 'Kategori Portofolio has been deleted!');
    }
}