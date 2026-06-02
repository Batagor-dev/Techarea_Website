<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Sertifikat;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

/**
 * @group Portofolio Data
 * 
 * API untuk mengambil data project dan sertifikat untuk keperluan landing page.
 */
class DataController extends Controller
{
    /**
     * Get All Data
     * 
     * Mengambil semua daftar project dan sertifikat sekaligus. 
     * Endpoint ini sangat disarankan untuk initial load pada frontend/landing page.
     */
public function allData(): JsonResponse
{
    $data = Cache::remember('all-data', 3600, function () {
        return [
            'projects' => Project::select(
                'name_project_id',
                'name_project_en',
                'image',
                'deskripsi_id',
                'deskripsi_en'
            )->get(),

            'sertifikats' => Sertifikat::select(
                'name_sertifikat_id',
                'name_sertifikat_en',
                'image',
                'deskripsi_id',
                'deskripsi_en'
            )->get(),
        ];
    });

    return response()->json([
        'success' => true,
        'message' => 'Data berhasil diambil',
        'data' => $data
    ]);
}

    /**
     * Detail Project
     * 
     * Mendapatkan informasi rinci mengenai satu project berdasarkan slug.
     * 
     * @urlParam project string required Slug dari project. Contoh: project-aplikasi-kasir
     */
    public function showProject(Project $project): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Detail project berhasil dimuat',
                'data'    => $project
            ], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Server Error', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Detail Sertifikat
     * 
     * Mendapatkan informasi rinci mengenai satu sertifikat berdasarkan slug.
     * 
     * @urlParam sertifikat string required Slug dari sertifikat. Contoh: sertifikat-laravel-expert
     */
    public function showSertifikat(Sertifikat $sertifikat): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Detail sertifikat berhasil dimuat',
                'data'    => $sertifikat
            ], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}