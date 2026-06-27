<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Portofolio;
use App\Models\Project;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            [
                'title' => 'Pengguna',
                'value' => User::count(),
                'icon' => 'ri-user-3-line',
                'color' => 'primary',
            ],
            [
                'title' => 'Project',
                'value' => Project::count(),
                'icon' => 'ri-briefcase-4-line',
                'color' => 'success',
            ],
            [
                'title' => 'Artikel',
                'value' => Article::count(),
                'icon' => 'ri-file-text-line',
                'color' => 'warning',
            ],
            [
                'title' => 'Portofolio',
                'value' => Portofolio::count(),
                'icon' => 'ri-image-line',
                'color' => 'info',
            ],
        ];

        $activityData = [12, 18, 15, 22, 27, 31, 26];
        $activityLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'];
        $statusData = [14, 9, 4];
        $statusLabels = ['Selesai', 'Diproses', 'Menunggu'];

        return view('dashboard.index', compact('stats', 'activityData', 'activityLabels', 'statusData', 'statusLabels'));
    }
}
