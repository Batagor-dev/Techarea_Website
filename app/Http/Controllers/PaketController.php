<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\KategoriPaket;
use App\Models\KelasPaket;
use App\Http\Requests\StorePaketRequest;
use App\Http\Requests\UpdatePaketRequest;
use App\DataTables\PaketDataTable;
use Illuminate\Support\Facades\Cache;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaketDataTable $dataTable)
    {
        return $dataTable->render('paket.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['kategori_pakets'] = KategoriPaket::orderBy('name_kategori_paket_id')->get();
        $this->data['kelas_pakets'] = KelasPaket::orderBy('name_kelas_paket_id')->get();
        $this->data['action'] = "/paket";

        return view('paket.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaketRequest $request)
    {
        $data = $request->validated();

        Paket::create($data);
        // dd($data);

        Cache::forget('all-data');

        return redirect('/paket')
            ->with('success', 'Kelas Paket berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Paket $paket)
    {
        $this->data['kategori_pakets'] = KategoriPaket::orderBy('name_kategori_id')->get();
        $this->data['kelas_pakets'] = KelasPaket::orderBy('name_kelas_paket_id')->get();
        $this->data['pakets'] = Paket::all();
        $this->data['paket_data'] = $paket;
        // dd($this->data['paket_kelas_data']);
        $this->data['action'] = "/paket/" . $paket->slug;

        return view('paket.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaketRequest $request, Paket $paket)
    {
        $data = $request->validated();

        $paket->update($data);

        Cache::forget('all-data');

        return redirect('/paket')
            ->with('success', 'Kelas Paket berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paket $paket)
    {
        $paket->delete();

        Cache::forget('all-data');

        return redirect('/paket')
            ->with('success', 'Kelas Paket berhasil dihapus!');
    }
}