<?php

namespace App\Http\Controllers;

use App\Models\KategoriPaket;
use App\Http\Requests\StoreKategoriPaketRequest;
use App\Http\Requests\UpdateKategoriPaketRequest;
use App\DataTables\KategoriPaketDataTable;
use Illuminate\Support\Facades\Cache;

class KategoriPaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KategoriPaketDataTable $dataTable)
    {
        return $dataTable->render('kategori_paket.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['action'] = "/kategori_paket";

        return view('kategori_paket.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriPaketRequest $request)
    {
        $data = $request->validated();

        KategoriPaket::create($data);
        // dd($data);

        Cache::forget('all-data');

        return redirect('/kategori_paket')
            ->with('success', 'Kategori Paket berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriPaket $kategori_paket)
    {
        $this->data['kategori_pakets'] = KategoriPaket::all();
        $this->data['kategori_paket_data'] = $kategori_paket;
        // dd($this->data['kategori_paket_data']);
        $this->data['action'] = "/kategori_paket/" . $kategori_paket->uuid;

        return view('kategori_paket.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriPaketRequest $request, KategoriPaket $kategori_paket)
    {
        $data = $request->validated();

        $kategori_paket->update($data);

        Cache::forget('all-data');

        return redirect('/kategori_paket')
            ->with('success', 'Kategori Paket berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriPaket $kategori_paket)
    {
        $kategori_paket->delete();

        Cache::forget('all-data');

        return redirect('/kategori_paket')
            ->with('success', 'Kategori Paket berhasil dihapus!');
    }
}