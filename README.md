<div align="center">

# Techarea

**Platform digital untuk manajemen layanan software, konten perusahaan, dan operasional admin internal.**

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![React](https://img.shields.io/badge/React-18-61DAFB?style=flat-square&logo=react&logoColor=black)](https://react.dev)
[![Inertia](https://img.shields.io/badge/Inertia.js-latest-9553E9?style=flat-square)](https://inertiajs.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

</div>

---

## Tentang Proyek

Techarea adalah platform internal perusahaan yang menggabungkan **company profile publik** dan **sistem manajemen admin** dalam satu aplikasi. Dibangun di atas Laravel 11 dengan frontend React + Inertia.js, proyek ini dirancang untuk:

- Menampilkan layanan dan portofolio perusahaan secara profesional
- Memudahkan tim admin mengelola seluruh konten website secara terpusat
- Menyediakan fondasi kode yang konsisten, maintainable, dan siap dikembangkan

---

## Fitur Utama

| Modul | Deskripsi |
|---|---|
| **Company Profile** | Halaman publik untuk promosi layanan perusahaan |
| **Manajemen Konten** | Menu, konten statis, dan pengaturan website |
| **Artikel & Kategori** | Blog / artikel perusahaan dengan sistem kategori |
| **Paket & Layanan** | Kelola paket, kelas paket, dan kategori project |
| **Project & Portofolio** | Tampilkan project dan portofolio dengan testimoni |
| **User & Permission** | Manajemen pengguna, role, dan permission berbasis Spatie |
| **Pengaturan Sistem** | Konfigurasi global konten dan sistem |
| **Integrasi AI** | Gemini API untuk kebutuhan konten dan operasional |

---

## Stack Teknologi

### Backend
- **Laravel 11** + **PHP 8.2 / 8.3**
- **MySQL** — database utama
- **Laravel Fortify** — autentikasi
- **Spatie Permission** — role & permission
- **Yajra DataTables** — tampilan data server-side
- **Laravel Breadcrumbs** — navigasi breadcrumb
- **Gemini API** — integrasi AI

### Frontend
- **React 18** + **Inertia.js** — SPA tanpa API terpisah
- **Tailwind CSS** + **shadcn/ui** — styling dan komponen UI
- **Blade** — template untuk halaman non-SPA
- **Vite** — build tool & dev server

---

## Struktur Proyek

```
app/
├── Http/
│   ├── Controllers/        # Request handler
│   └── Requests/           # FormRequest (validasi)
├── Models/                 # Eloquent model & relationship
├── Services/               # Logika bisnis kompleks
├── DataTables/             # Konfigurasi DataTables
├── Helpers/                # Helper function global
├── Observers/              # Event model
├── Rules/                  # Custom validation rule
└── Providers/              # Service provider

resources/
├── js/
│   ├── Pages/              # Halaman React (Inertia)
│   ├── Components/         # Komponen UI reusable
│   ├── Layouts/            # Layout aplikasi
│   ├── Hooks/              # Custom React hooks
│   └── Lib/                # Utility & constants
└── views/                  # Blade template

routes/                     # web.php & api.php
database/                   # migrations & seeders
tests/                      # Feature & Unit test
```

---

## Persiapan Lokal

### Prasyarat

Pastikan environment lokal sudah memiliki:
- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x
- MySQL >= 8.0

### Instalasi

```bash
# 1. Clone repository
git clone https://github.com/your-org/techarea.git
cd techarea

# 2. Install dependency PHP
composer install

# 3. Install dependency frontend
npm install

# 4. Salin file environment
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Konfigurasi database di .env
DB_DATABASE=techarea
DB_USERNAME=root
DB_PASSWORD=

# 7. Jalankan migrasi (+ seeder jika ada)
php artisan migrate --seed

# 8. Buat symlink storage
php artisan storage:link
```

### Menjalankan Aplikasi

Jalankan dua terminal secara bersamaan:

```bash
# Terminal 1 — Backend
php artisan serve

# Terminal 2 — Frontend (Vite dev server)
npm run dev
```

Aplikasi akan berjalan di `http://localhost:8000`.

---

## Panduan Pengembangan

Sebelum mulai coding, baca dua dokumen ini:

| Dokumen | Isi |
|---|---|
| [`AGENTS.md`](AGENTS.md) | Aturan backend: controller, model, service, naming, dll |
| [`Frontend.md`](Frontend.md) | Aturan frontend: React, Inertia, Tailwind, komponen, dll |

### Prinsip Utama

- Gunakan **FormRequest** untuk semua validasi input
- Pisahkan logika bisnis ke **Service** jika sudah kompleks
- Hindari **N+1 query** — selalu gunakan eager loading
- Gunakan **Inertia `useForm`** untuk semua form, bukan axios manual
- Tulis **Feature Test** untuk setiap endpoint penting

---

## Kontribusi

1. Buat branch baru dari `main`:
   ```bash
   git checkout -b feat/nama-fitur
   ```
2. Pastikan kode mengikuti standar di `AGENTS.md` dan `Frontend.md`
3. Jalankan test sebelum push:
   ```bash
   php artisan test
   ```
4. Buat pull request dengan deskripsi perubahan yang jelas

---

## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).