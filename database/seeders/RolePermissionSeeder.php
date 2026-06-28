<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissiongroups = [
            'User',
            'Role',
            'Permission Group',
            'Permission',
            'Menu',
            'Article Category',
            'Article',
            'Setting',
            'Management Project',
            'Kategori Project',
            'Project',
            'Management Portofolio',
            'Kategori Portofolio',
            'Portofolio',
            'Layanan',
            'Kelas Paket',
            'Kategori Paket',
            'Paket',
            'Testimoni',
            'Perusahaan'
        ];

        foreach ($permissiongroups as $permissiongroup) {
            PermissionGroup::create([
                'name' => $permissiongroup
            ]);
        }

        $permissions = [
            'User Access-1',
            'User Detail-1',
            'User Create-1',
            'User Update-1',
            'User Banned-1',
            'User Role Create-1',
            'Role Access-2',
            'Role Detail-2',
            'Role Create-2',
            'Role Update-2',
            'Role Delete-2',
            'Permission Group Access-3',
            'Permission Group Create-3',
            'Permission Group Update-3',
            'Permission Group Delete-3',
            'Permission Access-4',
            'Permission Create-4',
            'Permission Update-4',
            'Permission Delete-4',
            'Menu Access-5',
            'Menu Create-5',
            'Menu Update-5',
            'Menu Delete-5',
            'Article Category Access-6',
            'Article Category Create-6',
            'Article Category Update-6',
            'Article Category Delete-6',
            'Article Access-7',
            'Article Detail-7',
            'Article Create-7',
            'Article Update-7',
            'Article Delete-7',
            'Setting Access-8',
            'Setting Detail-8',
            'Setting Create-8',
            'Setting Update-8',
            'Setting Delete-8',
            'Management Project Access-9',
            'Management Project Detail-9',
            'Management Project Create-9',
            'Management Project Update-9',
            'Management Project Delete-9',
            'Kategori Project Access-10',
            'Kategori Project Detail-10',
            'Kategori Project Create-10',
            'Kategori Project Update-10',
            'Kategori Project Delete-10',
            'Project Access-11',
            'Project Detail-11',
            'Project Create-11',
            'Project Update-11',
            'Project Delete-11',
            'Management Portofolio Access-12',
            'Management Portofolio Create-12',
            'Management Portofolio Update-12',
            'Management Portofolio Delete-12',
            'Kategori Portofolio Access-13',
            'Kategori Portofolio Create-13',
            'Kategori Portofolio Update-13',
            'Kategori Portofolio Delete-13',
            'Portofolio Access-14',
            'Portofolio Create-14',
            'Portofolio Update-14',
            'Portofolio Delete-14',
            'Layanan Access-15',
            'Layanan Create-15',
            'Layanan Update-15',
            'Layanan Delete-15',
            'Kelas Paket Access-16',
            'Kelas Paket Create-16',
            'Kelas Paket Update-16',
            'Kelas Paket Delete-16',
            'Kategori Paket Access-17',
            'Kategori Paket Create-17',
            'Kategori Paket Update-17',
            'Kategori Paket Delete-17',
            'Paket Access-18',
            'Paket Create-18',
            'Paket Update-18',
            'Paket Delete-18',
            'Testimoni Access-19',
            'Testimoni Create-19',
            'Testimoni Update-19',
            'Testimoni Delete-19',
            'Perusahaan Access-20',
            'Perusahaan Create-20',
            'Perusahaan Update-20',
            'Perusahaan Delete-20',
        ];

        foreach ($permissions as $permission) {
            $permission_array = explode("-", $permission);
            Permission::create([
                'name' => $permission_array[0],
                'permission_group_id' => $permission_array[1]
            ]);
        }

        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web'
        ]);

        $superAdmin->givePermissionTo(Permission::all());

        $role = Role::create([
            'name' => 'User',
            'guard_name' => 'web'
        ]);
        $role->givePermissionTo('Article Access');
    }
}
