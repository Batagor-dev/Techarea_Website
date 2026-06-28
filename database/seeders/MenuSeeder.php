<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // === Menu 1: Artikel ===
        $artikel = Menu::create([
            'nama_menu'          => 'Artikel',
            'permission_group_id'=> 7, 
            'icon'               => 'ri-article-line',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $artikel->id,
            'nama_menu'          => 'Artikel Kategori',
            'permission_group_id'=> 7,
            'href'               => '/article_categories',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $artikel->id,
            'nama_menu'          => 'Artikel',
            'permission_group_id'=> 7,
            'href'               => '/article',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // === Menu 2: Setting ===
        $setting = Menu::create([
            'nama_menu'          => 'Setting',
            'permission_group_id'=> 8,
            'icon'               => 'ri-settings-3-line',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // Submenu User Management
        $userManagement = Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'User Management',
            'permission_group_id'=> 8,
            'status'             => '1',
            'sort'               => '1',
        ]);

        // Level 3 dari User Management
        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Users',
            'permission_group_id'=> 1,
            'href'               => '/user',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Permission Group',
            'permission_group_id'=> 8,
            'href'               => '/permissiongroup',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Permissions',
            'permission_group_id'=> 8,
            'href'               => '/permission',
            'status'             => '1',
            'sort'               => '3',
        ]);

        Menu::create([
            'menu_id'            => $userManagement->id,
            'nama_menu'          => 'Roles',
            'permission_group_id'=> 8,
            'href'               => '/role',
            'status'             => '1',
            'sort'               => '4',
        ]);

        // Submenu Web Setting (langsung di bawah Setting)
        Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'Web Setting',
            'permission_group_id'=> 8,
            'href'               => '/setting',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'menu_id'            => $setting->id,
            'nama_menu'          => 'Menu Management',
            'permission_group_id'=> 8,
            'href'               => '/menu',
            'status'             => '1',
            'sort'               => '3',
        ]);

        // Menu Perusahaan
        Menu::create([
            'nama_menu'          => 'Company',
            'permission_group_id'=> 20,
            'href'               => '/perusahaan',
            'icon'               => 'ri-building-line',
            'status'             => '1',
            'sort'               => '3',
        ]);

        // Menu Project
        $management_project = Menu::create([
            'nama_menu'          => 'Management Project',
            'permission_group_id'=> 9,
            'icon'               => 'ri-folders-line',
            'status'             => '1',
            'sort'               => '4',
        ]);

        Menu::create([
            'menu_id'            => $management_project->id,
            'nama_menu'          => 'Kategori Project',
            'permission_group_id'=> 10,
            'href'               => '/kategori_project',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $management_project->id,
            'nama_menu'          => 'Project',
            'permission_group_id'=> 11,
            'href'               => '/project',
            'status'             => '1',
            'sort'               => '2',
        ]);

        // Management Portofolio
        $management_portofolio = Menu::create([
            'nama_menu'          => 'Management Porto',
            'permission_group_id'=> 12,
            'icon'               => 'ri-briefcase-line',
            'status'             => '1',
            'sort'               => '5',
        ]);

        Menu::create([
            'menu_id'            => $management_portofolio->id,
            'nama_menu'          => 'Kategori Portofolio',
            'permission_group_id'=> 13,
            'href'               => '/kategori_portofolio',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $management_portofolio->id,
            'nama_menu'          => 'Portofolio',
            'permission_group_id'=> 14,
            'href'               => '/portofolio',
            'status'             => '1',
            'sort'               => '2',
        ]);

        $layanan = Menu::create([
            'nama_menu'          => 'Services',
            'permission_group_id'=> 15,
            'icon'               => 'ri-service-line',
            'status'             => '1',
            'sort'               => '6',
        ]);

        Menu::create([
            'menu_id'            => $layanan->id,
            'nama_menu'          => 'Package Class',
            'permission_group_id'=> 16,
            'href'               => '/kelas_paket',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $layanan->id,
            'nama_menu'          => 'Category Package',
            'permission_group_id'=> 17,
            'href'               => '/kategori_paket',
            'status'             => '1',
            'sort'               => '1',
        ]);

        Menu::create([
            'menu_id'            => $layanan->id,
            'nama_menu'          => 'Package',
            'permission_group_id'=> 18,
            'href'               => '/paket',
            'status'             => '1',
            'sort'               => '2',
        ]);

        Menu::create([
            'nama_menu'          => 'Testimoni',
            'permission_group_id'=> 19,
            'href'               => '/testimoni',
            'icon'               => 'ri-chat-1-line',
            'status'             => '1',
            'sort'               => '7',
        ]);

        // Management Invoice
        $management_invoice = Menu::create([
            'nama_menu'          => 'Management Invoice',
            'permission_group_id'=> 21,
            'icon'               => 'ri-bill-line',
            'status'             => '1',
            'sort'               => '8',
        ]);

        Menu::create([
            'menu_id'            => $management_invoice->id,
            'nama_menu'          => 'Payment Method',
            'permission_group_id'=> 22,
            'href'               => '/payment',
            'status'             => '1',
            'sort'               => '1',
        ]);
        
    }
}