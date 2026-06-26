# AGENTS.md — Techarea Project

> Baca file ini sebelum menulis kode apapun. Ikuti semua aturan di bawah tanpa pengecualian.

---

## 1. Project Overview

- **TechArea** adalah platform digital yang terdiri dari website company profile untuk menawarkan jasa pembuatan software dan solusi digital kepada klien, serta admin panel internal yang digunakan untuk mengelola konten website dan operasional perusahaan.

- **Backend**: Laravel 11 + MySQL
- **Frontend**: React (Inertia.js) + Tailwind CSS
- **Auth**: Laravel Fortify
- **Permission**: Spatie Permission
- **Table**: DataTables (server-side)
- **Asset**: Vite

---

## 2. Struktur Folder

```
app/
  Http/
    Controllers/      → Terima request, panggil service, return response
    Requests/         → Semua validasi pakai FormRequest (Store / Update)
    Middleware/       → Custom middleware
  Models/
    Traits/           → Trait reusable untuk model
  Services/           → Logika bisnis kompleks, integrasi eksternal
  Actions/            → Satu aksi terisolasi yang reusable
  DataTables/         → Konfigurasi DataTables server-side
  Helpers/            → Helper function global
  Observers/          → Event model (created, updated, deleted)
  Rules/              → Custom validation rule
  Providers/          → Service provider dan bootstrapping

database/
  migrations/         → Schema database
  seeders/            → Data awal

resources/
  js/                 → Entry point React + Inertia
    Pages/            → Halaman React (dirender oleh Inertia)
    Components/       → Komponen UI reusable
    Layouts/          → Layout utama (AppLayout, AuthLayout, dll)
    Hooks/            → Custom React hooks
    Lib/              → Utility / helper frontend

routes/
  web.php             → Route utama aplikasi
  api.php             → Route API (jika ada)

tests/
  Feature/            → Feature test
  Unit/               → Unit test
```

---

## 3. Naming Convention

| Layer | Format | Contoh |
|---|---|---|
| Controller | `NamaController` | `ProjectController` |
| Model | `NamaModel` (singular) | `Project` |
| FormRequest | `StoreNamaRequest` / `UpdateNamaRequest` | `StoreProjectRequest` |
| Service | `NamaService` | `ProjectService` |
| Observer | `NamaObserver` | `ProjectObserver` |
| DataTable | `NamaDataTable` | `ProjectDataTable` |
| Action | `NamaAction` | `AssignMemberAction` |
| Migration | `create_nama_table` | `create_projects_table` |
| Test | `NamaFeatureTest` / `NamaUnitTest` | `ProjectFeatureTest` |
| React Page | `NamaPage.jsx` (PascalCase) | `ProjectDetailPage.jsx` |
| React Component | `NamaComponent.jsx` (PascalCase) | `ProjectCard.jsx` |

---

## 4. Backend Rules

### Controller
- Hanya bertugas menerima request dan mengembalikan response.
- Jangan taruh logika bisnis di controller — pindahkan ke Service.
- Gunakan route resource jika cocok: `Route::resource('projects', ProjectController::class)`.
- Selalu gunakan FormRequest, bukan `$request->validate()` langsung.

```php
// ✅ Benar
public function store(StoreProjectRequest $request, ProjectService $service)
{
    $project = $service->create($request->validated());
    return redirect()->route('projects.index')->with('success', 'Project berhasil dibuat.');
}

// ❌ Salah
public function store(Request $request)
{
    $request->validate([...]);
    Project::create($request->all());
}
```

### Model
- Definisikan `$fillable`, `$casts`, relationship, dan scope dengan jelas.
- Gunakan soft deletes jika data tidak boleh dihapus permanen.
- Taruh trait reusable di `app/Models/Traits/`.

```php
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'status', 'client_id', 'started_at'];

    protected $casts = [
        'started_at' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }
}
```

### Service
- Gunakan untuk logika kompleks, multi-step, atau integrasi eksternal.
- Inject via constructor (Dependency Injection).

```php
class ProjectService
{
    public function __construct(
        private readonly GeminiService $gemini,
    ) {}

    public function create(array $data): Project
    {
        // logika kompleks di sini
    }
}
```

### Query & Performance
- **Selalu** gunakan eager loading untuk relasi: `->with(['client', 'members'])`.
- Jangan query di dalam loop.
- Gunakan pagination atau DataTables untuk list data besar.
- Cache data master yang jarang berubah.

```php
// ✅ Benar
$projects = Project::with(['client', 'members'])->paginate(20);

// ❌ Salah
$projects = Project::all();
foreach ($projects as $project) {
    echo $project->client->name; // N+1 query
}
```

### Authorization
- Gunakan Spatie Permission untuk role/permission.
- Gunakan Laravel Policy untuk resource-level authorization.
- Jangan hardcode permission check di controller — gunakan `$this->authorize()` atau `can()`.

---

## 5. Frontend Rules

> Detail lengkap ada di `Frontend.md`. Ringkasan singkat:

- Halaman Blade di `resources/view/`
- Saat membuat halaman atau form baru, gunakan desain dan struktur Blade yang sudah ada sebagai referensi.
- Pertahankan konsistensi layout, komponen, spacing, dan styling dengan halaman Blade yang sudah ada.
- Halaman React di `resources/js/Pages/`.
- Komponen di `resources/js/Components/`.
- Gunakan Inertia `Link`, `router`, dan `useForm` — jangan `fetch` manual untuk navigasi.
- Ikuti panduan styling di `Frontend.md` & `UI-UX.md`.

---

## 6. Larangan Keras (Jangan Dilakukan)

```
❌ dd(), dump(), var_dump() di production
❌ Query langsung dari Blade / JSX
❌ Hardcode URL, warna, label yang seharusnya configurable
❌ Duplicate code — refactor ke helper / service / komponen
❌ Install package baru tanpa diskusi
❌ Hapus kode yang sudah berjalan tanpa memastikan dampaknya
❌ Ubah struktur folder tanpa alasan yang jelas
❌ Logika bisnis di controller (lebih dari 20 baris → pindah ke Service)
```

---

## 7. Testing

- Tulis **Feature Test** untuk semua endpoint penting.
- Tulis **Unit Test** untuk Service dan Action class.
- Gunakan Pest (preferensi) atau PHPUnit.
- Jalankan test sebelum push: `php artisan test`.

```php
it('can create a project', function () {
    $user = User::factory()->create();
    $this->actingAs($user)
         ->post('/projects', ['name' => 'Test Project', ...])
         ->assertRedirect('/projects');
});
```

---

## 8. Checklist Sebelum Selesai

Sebelum menyatakan task selesai, pastikan:

- [ ] Tidak ada `dd()` atau `console.log` tertinggal
- [ ] Validasi menggunakan FormRequest
- [ ] Tidak ada N+1 query (cek dengan Telescope atau log)
- [ ] Nama class, method, dan variable deskriptif
- [ ] Tidak ada logika bisnis di controller atau view
- [ ] Test sudah ditulis atau diperbarui
- [ ] Tidak ada hardcode value yang seharusnya configurable