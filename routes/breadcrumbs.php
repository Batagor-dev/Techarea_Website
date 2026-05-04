<?php
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('dashboard'));
});


// **************************** USER ***************************

// Home > User
Breadcrumbs::for('user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('User', route('user.index'));
});

// Home > User > [Update]
Breadcrumbs::for('user.edit', function (BreadcrumbTrail $trail, $user) {
    // dd($user);
    $trail->parent('user.index');
    $trail->push('Update [' . $user->name . ']', route('user.edit', $user));
});

// Home > User > Create
Breadcrumbs::for('user.create', function (BreadcrumbTrail $trail) {
    $trail->parent('user.index');
    $trail->push('Create', route('user.create'));
});

// Home > User > Permission
Breadcrumbs::for('user.show', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.index');
    $trail->push('User Permission', route('user.show', $user));
});

// Home > User > Permission
Breadcrumbs::for('user.role', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('user.index');
    $trail->push('User Roles [' . $user->name . ']', route('user.role', $user));
});

// **************************** END USER ***************************


// **************************** ROLE ***************************

// Home > Role
Breadcrumbs::for('role.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Role', route('role.index'));
});

// Home > Role > [Update]
Breadcrumbs::for('role.edit', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('role.index');
    $trail->push('Update [' . $role->name . ']', route('role.edit', $role));
});

// Home > Role > Create
Breadcrumbs::for('role.create', function (BreadcrumbTrail $trail) {
    $trail->parent('role.index');
    $trail->push('Create', route('role.create'));
});

// Home > Role > Permission
Breadcrumbs::for('role.show', function (BreadcrumbTrail $trail, $role) {
    $trail->parent('role.index');
    $trail->push('Role Permission', route('role.show', $role));
});

// **************************** END ROLE ***************************


// **************************** PERMISSION ***************************

// Home > Permission
Breadcrumbs::for('permission.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Permission', route('permission.index'));
});

// Home > Permission > [Update]
Breadcrumbs::for('permission.edit', function (BreadcrumbTrail $trail, $permission) {
    $trail->parent('permission.index');
    $trail->push('Update [' . $permission->name . ']', route('permission.edit', $permission));
});

// Home > Permission > Create
Breadcrumbs::for('permission.create', function (BreadcrumbTrail $trail) {
    $trail->parent('permission.index');
    $trail->push('Create', route('permission.create'));
});

// **************************** END PERMISSION ***************************


// **************************** PERMISSION GROUP ***************************

// Home > Permission Group
Breadcrumbs::for('permissiongroup.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Permission Group', route('permissiongroup.index'));
});

// Home > Permission Group > [Update]
Breadcrumbs::for('permissiongroup.edit', function (BreadcrumbTrail $trail, $permissiongroup) {
    $trail->parent('permissiongroup.index');
    $trail->push('Update [' . $permissiongroup->name . ']', route('permissiongroup.edit', $permissiongroup));
});

// Home > Permission Group > Create
Breadcrumbs::for('permissiongroup.create', function (BreadcrumbTrail $trail) {
    $trail->parent('permissiongroup.index');
    $trail->push('Create', route('permissiongroup.create'));
});

// **************************** END PERMISSION GROUP ***************************


// **************************** MENU ***************************

// Home > Menu
Breadcrumbs::for('menu.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Menu', route('menu.index'));
});

// Home > Menu > [Update]
Breadcrumbs::for('menu.edit', function (BreadcrumbTrail $trail, $menu) {
    $trail->parent('menu.index');
    $trail->push('Update [' . $menu->nama_menu . ']', route('menu.edit', $menu));
});

// Home > Menu > Create
Breadcrumbs::for('menu.create', function (BreadcrumbTrail $trail) {
    $trail->parent('menu.index');
    $trail->push('Create', route('menu.create'));
});

// **************************** END MENU ***************************


// **************************** ARTICLE CATEGORY ***************************

// Home > Article Categories
Breadcrumbs::for('article_categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Article Categories', route('article_categories.index'));
});

// Home > Article Categories > [Update]
Breadcrumbs::for('article_categories.edit', function (BreadcrumbTrail $trail, $article_categories) {
    $trail->parent('article_categories.index');
    $trail->push('Update [' . $article_categories->name . ']', route('article_categories.edit', $article_categories));
});

// Home > Article Categories > Create
Breadcrumbs::for('article_categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('article_categories.index');
    $trail->push('Create', route('article_categories.create'));
});

// **************************** END ARTICLE CATEGORY ***************************


// **************************** SETTING ***************************

// Home > Article Categories
Breadcrumbs::for('setting.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Web Setting', route('setting.index'));
});

// **************************** END SETTING ***************************

// **************************** ACOUNT ***************************

// Home > Acount > Profile
Breadcrumbs::for('acount.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Account', route('acount.index'));
});

// Home > Acount > Setting
Breadcrumbs::for('acount.security', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Account', route('acount.security'));
});

// **************************** END ACOUNT ***************************

// **************************** ARTICLE ***************************

// Home > Article Categories
Breadcrumbs::for('article.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Article', route('article.index'));
});

// Home > Article Categories > [Update]
Breadcrumbs::for('article.edit', function (BreadcrumbTrail $trail, $article) {
    $trail->parent('article.index');
    $trail->push('Update [' . $article->title . ']', route('article.edit', $article));
});

// Home > Article Categories > Create
Breadcrumbs::for('article.create', function (BreadcrumbTrail $trail) {
    $trail->parent('article.index');
    $trail->push('Create', route('article.create'));
});

// Home > Article Categories > Create
Breadcrumbs::for('article.show', function (BreadcrumbTrail $trail, $article) {
    $trail->parent('article.index');
    $trail->push('Article ' . $article->title, route('article.show', $article));
});

// **************************** END ARTICLE ***************************

// **************************** Project ***************************

// Home > Project
Breadcrumbs::for('project.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Project Portofolio', route('project.index'));
});

// Home > Project > [Update]
Breadcrumbs::for('project.edit', function (BreadcrumbTrail $trail, $project) {
    $trail->parent('project.index');
    $trail->push('Update [' . $project->name_project_id . ']', route('project.edit', $project));
});

// Home > Project > Create
Breadcrumbs::for('project.create', function (BreadcrumbTrail $trail) {
    $trail->parent('project.index');
    $trail->push('Create', route('project.create'));
});

// **************************** END Project ***************************

// **************************** Sertifikat ***************************

// Home > Sertifikat
Breadcrumbs::for('sertifikat.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Sertifikat Portofolio', route('sertifikat.index'));
});

// Home > Sertifikat > [Update]
Breadcrumbs::for('sertifikat.edit', function (BreadcrumbTrail $trail, $sertifikat) {
    $trail->parent('sertifikat.index');
    $trail->push('Update [' . $sertifikat->name_sertifikat_id . ']', route('sertifikat.edit', $sertifikat));
});

// Home > Sertifikat > Create
Breadcrumbs::for('sertifikat.create', function (BreadcrumbTrail $trail) {
    $trail->parent('sertifikat.index');
    $trail->push('Create', route('sertifikat.create'));
});

// **************************** END Sertifikat ***************************