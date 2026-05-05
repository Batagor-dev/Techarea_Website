<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Sertifikat;
use Exception;
use Illuminate\Http\JsonResponse;

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
        try {
            return response()->json([
                'success' => true,
                'message' => 'Semua data berhasil diambil',
                'data' => [
                    'projects' => Project::all(),
                    'sertifikats' => Sertifikat::all(),
                ]
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
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