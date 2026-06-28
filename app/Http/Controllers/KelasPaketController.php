<?php

namespace App\Http\Controllers;

use App\Models\KelasPaket;
use App\Http\Requests\StoreKelasPaketRequest;
use App\Http\Requests\UpdateKelasPaketRequest;
use App\DataTables\KelasPaketDataTable;
use Illuminate\Support\Facades\Cache;

class KelasPaketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KelasPaketDataTable $dataTable)
    {
        return $dataTable->render('kelas_paket.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['action'] = "/kelas_paket";

        return view('kelas_paket.form', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelasPaketRequest $request)
    {
        $data = $request->validated();

        KelasPaket::create($data);
        // dd($data);

        Cache::forget('all-data');

        return redirect('/kelas_paket')
            ->with('success', 'Kelas Paket berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KelasPaket $kelas_paket)
    {
        $this->data['kelas_pakets'] = KelasPaket::all();
        $this->data['paket_kelas_data'] = $kelas_paket;
        // dd($this->data['paket_kelas_data']);
        $this->data['action'] = "/kelas_paket/" . $kelas_paket->uuid;

        return view('kelas_paket.form', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKelasPaketRequest $request, KelasPaket $kelas_paket)
    {
        $data = $request->validated();

        $kelas_paket->update($data);

        Cache::forget('all-data');

        return redirect('/kelas_paket')
            ->with('success', 'Kelas Paket berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KelasPaket $kelas_paket)
    {
        $kelas_paket->delete();

        Cache::forget('all-data');

        return redirect('/kelas_paket')
            ->with('success', 'Kelas Paket berhasil dihapus!');
    }
}