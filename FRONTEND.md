# Frontend.md — Techarea Frontend Guide

> Panduan ini wajib dibaca sebelum membuat atau mengubah file apapun di `resources/js/`.
> Stack: **React + Inertia.js + Tailwind CSS + shadcn/ui + Satoshi (Fontshare)**

---

## 1. Stack & Tools

| Tool | Versi | Kegunaan |
|---|---|---|
| React | 18 | UI library utama |
| Inertia.js | latest | Jembatan Laravel ↔ React (SPA tanpa API) |
| Tailwind CSS | 3.x | Utility-first styling |
| shadcn/ui | latest | Komponen UI accessible berbasis Radix UI |
| Satoshi | — | Font utama dari Fontshare |
| Lucide React | latest | Icon library |
| clsx + tailwind-merge | latest | Class kondisional yang aman |
| Vite | latest | Build tool & dev server |

---

## 2. Setup Awal

### 2.1 Font — Satoshi via Fontshare

Tambahkan di `resources/css/app.css`:

```css
/* resources/css/app.css */
@import url('https://api.fontshare.com/v2/css?f[]=satoshi@400,500,600,700,900&display=swap');

@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  html {
    font-family: 'Satoshi', sans-serif;
  }
}
```

### 2.2 Tailwind Config

```js
// tailwind.config.js
/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    './resources/js/**/*.{js,jsx,ts,tsx}',
    './resources/views/**/*.blade.php',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Satoshi', 'sans-serif'],
      },
      colors: {
        brand: {
          50:  '#f0f4ff',
          100: '#dde6ff',
          200: '#c3d0ff',
          300: '#9db0ff',
          400: '#7589ff',
          500: '#5263f5',
          600: '#3d47e8',
          700: '#3035cc',
          800: '#2a2da5',
          900: '#282c82',
        },
        surface: {
          DEFAULT: '#ffffff',
          muted:   '#f8fafc',
          subtle:  '#f1f5f9',
          border:  '#e2e8f0',
        },
      },
      borderRadius: {
        DEFAULT: '0.5rem',
        lg:  '0.75rem',
        xl:  '1rem',
        '2xl': '1.25rem',
      },
      fontSize: {
        // Satoshi tampil optimal di ukuran ini
        'display': ['2.25rem', { lineHeight: '2.5rem',  letterSpacing: '-0.02em', fontWeight: '700' }],
        'heading':  ['1.5rem',  { lineHeight: '2rem',    letterSpacing: '-0.01em', fontWeight: '600' }],
        'subhead':  ['1.125rem',{ lineHeight: '1.75rem', letterSpacing: '-0.01em', fontWeight: '500' }],
      },
      boxShadow: {
        'card': '0 1px 3px 0 rgb(0 0 0 / 0.06), 0 1px 2px -1px rgb(0 0 0 / 0.06)',
        'card-hover': '0 4px 6px -1px rgb(0 0 0 / 0.08), 0 2px 4px -2px rgb(0 0 0 / 0.06)',
        'modal': '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
      },
    },
  },
  plugins: [require('tailwindcss-animate')],
}
```

### 2.3 Setup shadcn/ui

```bash
# Install shadcn/ui (jalankan sekali saat setup project)
npx shadcn@latest init

# Tambah komponen yang dibutuhkan
npx shadcn@latest add button input label select textarea
npx shadcn@latest add dialog sheet drawer
npx shadcn@latest add table badge avatar card
npx shadcn@latest add dropdown-menu command
npx shadcn@latest add toast sonner
npx shadcn@latest add separator skeleton
```

Sesuaikan `components.json` agar path alias cocok dengan struktur Inertia:

```json
{
  "$schema": "https://ui.shadcn.com/schema.json",
  "style": "default",
  "rsc": false,
  "tsx": false,
  "tailwind": {
    "config": "tailwind.config.js",
    "css": "resources/css/app.css",
    "baseColor": "slate",
    "cssVariables": true
  },
  "aliases": {
    "components": "@/Components",
    "utils": "@/Lib/utils"
  }
}
```

---

## 3. Struktur Folder Frontend

```
resources/js/
  Pages/                    → Halaman full (dirender Inertia dari controller)
    Auth/                   → Login, Register, ForgotPassword
    Dashboard/              → Index.jsx
    Projects/               → Index.jsx, Create.jsx, Edit.jsx, Show.jsx
      Partials/             → Sub-komponen spesifik halaman ini
        ProjectCard.jsx
        FilterBar.jsx
        StatusBadge.jsx

  Components/
    ui/                     → Komponen shadcn/ui (jangan edit manual)
      button.jsx
      input.jsx
      dialog.jsx
      ...
    ReactBits/              → Komponen animasi dari reactbits.dev (copy-paste, bisa diedit)
      CountUp.jsx           → Angka animasi untuk stat card
      BlurText.jsx          → Heading dengan efek blur-in
      SplitText.jsx         → Teks masuk per karakter/kata
      ScrollReveal.jsx      → Animasi saat scroll
      GradientText.jsx      → Teks dengan gradient warna brand
    App/                    → Komponen custom level aplikasi
      DataTable.jsx         → Wrapper DataTable dengan style Techarea
      PageHeader.jsx        → Header halaman standar (title + action button)
      ConfirmDialog.jsx     → Dialog konfirmasi hapus / aksi destruktif
      EmptyState.jsx        → Tampilan saat data kosong
      StatusBadge.jsx       → Badge status project/task yang reusable
      AvatarGroup.jsx       → Grup avatar member
    Forms/                  → Form komponen spesifik domain
      ProjectForm.jsx
      MemberForm.jsx

  Layouts/
    AppLayout.jsx           → Layout utama (sidebar + topbar)
    AuthLayout.jsx          → Layout halaman auth (centered card)
    GuestLayout.jsx         → Layout untuk halaman publik

  Hooks/
    useDebounce.js          → Debounce input search
    usePermission.js        → Cek permission user saat ini
    useToast.js             → Shortcut toast notification

  Lib/
    utils.js                → cn(), formatDate(), formatCurrency(), dll
    constants.js            → STATUS, ROLES, PRIORITY — nilai konstan
```

---

## 4. Naming Convention

| Tipe | Format | Contoh |
|---|---|---|
| Page | `NamaHalaman.jsx` (PascalCase) | `ProjectIndex.jsx` |
| Component | `NamaKomponen.jsx` (PascalCase) | `ProjectCard.jsx` |
| Hook | `useNamaHook.js` (camelCase) | `useDebounce.js` |
| Utility | `namaUtil.js` (camelCase) | `utils.js` |
| Constant | `NAMA_CONSTANT` (SCREAMING_SNAKE) | `PROJECT_STATUS` |

---

## 5. Inertia.js Rules

### Navigasi — selalu pakai Inertia, bukan `<a>` biasa

```jsx
// ✅ Benar
import { Link, router } from '@inertiajs/react';

<Link href={route('projects.show', project.id)}>Lihat Detail</Link>

// Programmatic navigation
router.visit(route('projects.index'));

// Dengan method
router.delete(route('projects.destroy', project.id), {
  onSuccess: () => toast.success('Project dihapus'),
});
```

```jsx
// ❌ Salah
<a href="/projects/1">Lihat Detail</a>
window.location.href = '/projects';
axios.delete('/projects/1');
```

### Form — selalu pakai `useForm` dari Inertia

```jsx
import { useForm } from '@inertiajs/react';

const { data, setData, post, put, processing, errors, reset } = useForm({
  name: project?.name ?? '',
  status: project?.status ?? 'active',
  description: project?.description ?? '',
});

const handleSubmit = (e) => {
  e.preventDefault();
  // Store
  post(route('projects.store'), { onSuccess: () => reset() });
  // Update
  put(route('projects.update', project.id));
};

// Tampilkan error dari backend
{errors.name && (
  <p className="text-sm text-destructive mt-1">{errors.name}</p>
)}
```

### Data dari Controller — kirim via Inertia, bukan fetch di useEffect

```php
// ✅ Benar — Controller mengirim data
return Inertia::render('Projects/Index', [
    'projects' => ProjectResource::collection($projects),
    'filters'  => $request->only(['search', 'status']),
    'stats'    => $this->getStats(),
]);
```

```jsx
// Page langsung terima sebagai props
export default function ProjectIndex({ projects, filters, stats }) {
  // Tidak perlu useEffect + fetch
}
```

```jsx
// ❌ Salah
useEffect(() => {
  fetch('/api/projects').then(...) // Jangan lakukan ini untuk page load
}, []);
```

---

## 6. Komponen shadcn/ui — Cara Pakai

shadcn/ui sudah accessible dan styled. Gunakan langsung, extend via `className` jika perlu.

### Button

```jsx
import { Button } from '@/Components/ui/button';

// Variants bawaan shadcn
<Button variant="default">Simpan</Button>
<Button variant="destructive">Hapus</Button>
<Button variant="outline">Batal</Button>
<Button variant="ghost">Lihat</Button>
<Button variant="secondary">Export</Button>

// Dengan icon (Lucide React)
import { Plus, Trash2, Loader2 } from 'lucide-react';

<Button>
  <Plus className="w-4 h-4 mr-2" />
  Tambah Project
</Button>

// Loading state
<Button disabled={processing}>
  {processing && <Loader2 className="w-4 h-4 mr-2 animate-spin" />}
  {processing ? 'Menyimpan...' : 'Simpan'}
</Button>
```

### Input + Label + Error

```jsx
import { Input }  from '@/Components/ui/input';
import { Label }  from '@/Components/ui/label';

<div className="space-y-1.5">
  <Label htmlFor="name">Nama Project</Label>
  <Input
    id="name"
    value={data.name}
    onChange={(e) => setData('name', e.target.value)}
    placeholder="Masukkan nama project"
    className={errors.name ? 'border-destructive' : ''}
  />
  {errors.name && (
    <p className="text-sm text-destructive">{errors.name}</p>
  )}
</div>
```

### Dialog (Konfirmasi Hapus)

```jsx
import {
  Dialog, DialogContent, DialogHeader,
  DialogTitle, DialogFooter, DialogTrigger,
} from '@/Components/ui/dialog';

function DeleteConfirmDialog({ project, onConfirm }) {
  return (
    <Dialog>
      <DialogTrigger asChild>
        <Button variant="destructive" size="sm">
          <Trash2 className="w-4 h-4" />
        </Button>
      </DialogTrigger>
      <DialogContent className="max-w-sm">
        <DialogHeader>
          <DialogTitle>Hapus Project?</DialogTitle>
        </DialogHeader>
        <p className="text-sm text-muted-foreground">
          Project <span className="font-medium text-foreground">"{project.name}"</span> akan
          dihapus permanen. Aksi ini tidak bisa dibatalkan.
        </p>
        <DialogFooter className="gap-2">
          <DialogTrigger asChild>
            <Button variant="outline">Batal</Button>
          </DialogTrigger>
          <Button variant="destructive" onClick={onConfirm}>
            Ya, Hapus
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  );
}
```

### Badge Status

```jsx
import { Badge } from '@/Components/ui/badge';
import { PROJECT_STATUS } from '@/Lib/constants';

// constants.js mendefinisikan variant per status
export function StatusBadge({ status }) {
  const config = PROJECT_STATUS[status] ?? PROJECT_STATUS.default;
  return (
    <Badge variant={config.variant}>
      {config.label}
    </Badge>
  );
}

// Pemakaian
<StatusBadge status={project.status} />
```

### Table

```jsx
import {
  Table, TableBody, TableCell,
  TableHead, TableHeader, TableRow,
} from '@/Components/ui/table';

<Table>
  <TableHeader>
    <TableRow>
      <TableHead>Nama Project</TableHead>
      <TableHead>Status</TableHead>
      <TableHead>Deadline</TableHead>
      <TableHead className="text-right">Aksi</TableHead>
    </TableRow>
  </TableHeader>
  <TableBody>
    {projects.data.map((project) => (
      <TableRow key={project.id}>
        <TableCell className="font-medium">{project.name}</TableCell>
        <TableCell><StatusBadge status={project.status} /></TableCell>
        <TableCell>{formatDate(project.deadline)}</TableCell>
        <TableCell className="text-right">
          <RowActions project={project} />
        </TableCell>
      </TableRow>
    ))}
  </TableBody>
</Table>
```

---

## 7. Komponen Custom Wajib Dibuat

Buat komponen ini di `Components/App/` dan gunakan di semua halaman — jangan tulis ulang per halaman.

### PageHeader

```jsx
// Components/App/PageHeader.jsx
export function PageHeader({ title, description, children }) {
  return (
    <div className="flex items-start justify-between mb-6">
      <div>
        <h1 className="text-2xl font-semibold tracking-tight text-foreground">
          {title}
        </h1>
        {description && (
          <p className="text-sm text-muted-foreground mt-1">{description}</p>
        )}
      </div>
      {children && (
        <div className="flex items-center gap-2">{children}</div>
      )}
    </div>
  );
}

// Pemakaian
<PageHeader
  title="Projects"
  description="Kelola semua project yang sedang berjalan"
>
  <Button onClick={() => router.visit(route('projects.create'))}>
    <Plus className="w-4 h-4 mr-2" />
    Tambah Project
  </Button>
</PageHeader>
```

### EmptyState

```jsx
// Components/App/EmptyState.jsx
export function EmptyState({ icon: Icon, title, description, action }) {
  return (
    <div className="flex flex-col items-center justify-center py-16 text-center">
      <div className="w-12 h-12 rounded-xl bg-muted flex items-center justify-center mb-4">
        {Icon && <Icon className="w-6 h-6 text-muted-foreground" />}
      </div>
      <h3 className="text-sm font-semibold text-foreground mb-1">{title}</h3>
      {description && (
        <p className="text-sm text-muted-foreground max-w-xs">{description}</p>
      )}
      {action && <div className="mt-4">{action}</div>}
    </div>
  );
}
```

---

## 8. Struktur Halaman Standar

```jsx
import AppLayout from '@/Layouts/AppLayout';
import { Head }  from '@inertiajs/react';
import { PageHeader } from '@/Components/App/PageHeader';
import { Button }     from '@/Components/ui/button';
import { Plus }       from 'lucide-react';

export default function ProjectIndex({ projects, filters }) {
  return (
    <AppLayout>
      <Head title="Projects" />

      <PageHeader
        title="Projects"
        description="Kelola semua project yang sedang berjalan"
      >
        <Link href={route('projects.create')}>
          <Button>
            <Plus className="w-4 h-4 mr-2" />
            Tambah Project
          </Button>
        </Link>
      </PageHeader>

      {/* Filter Bar */}
      <div className="flex items-center gap-3 mb-4">
        <Input placeholder="Cari project..." className="max-w-sm" />
        {/* ... filter lain */}
      </div>

      {/* Content Card */}
      <div className="rounded-xl border border-border bg-card shadow-card">
        {projects.data.length === 0 ? (
          <EmptyState
            icon={FolderOpen}
            title="Belum ada project"
            description="Mulai dengan membuat project pertama kamu"
            action={
              <Link href={route('projects.create')}>
                <Button size="sm">Buat Project</Button>
              </Link>
            }
          />
        ) : (
          <ProjectTable projects={projects} />
        )}
      </div>

      {/* Pagination */}
      {projects.meta.last_page > 1 && (
        <Pagination links={projects.meta.links} className="mt-4" />
      )}
    </AppLayout>
  );
}
```

---

## 9. Spacing & Typography — Referensi Cepat

### Spacing

| Konteks | Class Tailwind |
|---|---|
| Padding halaman (wrapper) | `p-6` atau `px-6 py-5` |
| Gap antar section besar | `mb-8` atau `space-y-8` |
| Gap antar card / komponen | `mb-6` atau `gap-6` |
| Padding dalam card | `p-5` |
| Gap antar field form | `space-y-4` |
| Gap antar item kecil | `gap-2` atau `gap-3` |

### Typography (Satoshi)

| Kegunaan | Class |
|---|---|
| Page title (H1) | `text-2xl font-semibold tracking-tight` |
| Section title (H2) | `text-lg font-semibold` |
| Card title (H3) | `text-base font-medium` |
| Body / label | `text-sm font-normal` |
| Caption / helper text | `text-xs text-muted-foreground` |
| Angka / metric besar | `text-3xl font-bold tabular-nums` |

> Satoshi bekerja paling baik dengan `tracking-tight` di heading dan `font-medium` untuk label.

---

## 10. Warna — Pakai CSS Variable shadcn/ui

shadcn/ui sudah mendefinisikan CSS variable. Gunakan token ini, bukan warna Tailwind mentah.

| Token | Kegunaan |
|---|---|
| `bg-background` | Background halaman utama |
| `bg-card` | Background card / panel |
| `bg-muted` | Background elemen subtle (input, badge) |
| `text-foreground` | Teks utama |
| `text-muted-foreground` | Teks sekunder / helper |
| `border-border` | Border default |
| `bg-primary` | Warna aksi utama (brand) |
| `text-primary-foreground` | Teks di atas primary |
| `bg-destructive` | Warna aksi destruktif (hapus) |

```jsx
// ✅ Benar — pakai token shadcn
<div className="bg-card border border-border rounded-xl p-5">
  <h3 className="text-foreground font-medium">Judul</h3>
  <p className="text-muted-foreground text-sm">Deskripsi</p>
</div>

// ❌ Salah — hardcode warna
<div className="bg-white border border-gray-200" style={{ color: '#111827' }}>
```

---

## 11. Constants — Satu Tempat, Pakai Ulang

```js
// Lib/constants.js

export const PROJECT_STATUS = {
  active:    { label: 'Aktif',       variant: 'default'     },
  on_hold:   { label: 'On Hold',     variant: 'secondary'   },
  completed: { label: 'Selesai',     variant: 'outline'     },
  cancelled: { label: 'Dibatalkan',  variant: 'destructive' },
  default:   { label: 'Unknown',     variant: 'outline'     },
};

export const PRIORITY = {
  low:    { label: 'Rendah',  className: 'text-green-600'  },
  medium: { label: 'Sedang',  className: 'text-yellow-600' },
  high:   { label: 'Tinggi',  className: 'text-red-600'    },
};

export const ROLES = {
  admin:   'Admin',
  manager: 'Manager',
  member:  'Member',
};
```

---

## 12. Utility Functions

```js
// Lib/utils.js
import { clsx }    from 'clsx';
import { twMerge } from 'tailwind-merge';

// Wajib ada — class kondisional yang aman
export function cn(...inputs) {
  return twMerge(clsx(inputs));
}

// Format tanggal (konsisten di seluruh app)
export function formatDate(date, options = {}) {
  if (!date) return '—';
  return new Intl.DateTimeFormat('id-ID', {
    day:   'numeric',
    month: 'short',
    year:  'numeric',
    ...options,
  }).format(new Date(date));
}

// Format angka ke Rupiah
export function formatCurrency(amount) {
  if (amount == null) return '—';
  return new Intl.NumberFormat('id-ID', {
    style:    'currency',
    currency: 'IDR',
    maximumFractionDigits: 0,
  }).format(amount);
}

// Potong teks panjang
export function truncate(str, maxLength = 60) {
  if (!str) return '';
  return str.length > maxLength ? str.slice(0, maxLength) + '…' : str;
}
```

---

## 13. React Bits — Komponen Animasi Modern

> **React Bits** (`reactbits.dev`) adalah library komponen animasi open source — bukan pengganti shadcn/ui, tapi pelengkap untuk elemen visual yang butuh "wow factor".
> Kode di-copy ke project kamu sendiri (bukan dependency), jadi 100% bisa dimodifikasi.

### Filosofi Penggunaan di Techarea

React Bits bukan untuk semua halaman. Gunakan dengan bijak:

| Gunakan React Bits untuk | Jangan gunakan untuk |
|---|---|
| Hero section / landing page | Form input, table data |
| Dashboard stat cards yang menarik | Navigasi / sidebar |
| Loading screen / splash | Komponen yang dirender ratusan kali |
| Empty state yang memorable | Setiap halaman (overkill) |
| Onboarding / welcome screen | — |

> ⚠️ **Aturan React Bits sendiri**: Jangan pakai lebih dari 2-3 animated component per halaman — bisa berdampak ke performa dan UX.

---

### Install via CLI (shadcn-compatible)

```bash
# Install komponen spesifik via shadcn CLI
npx shadcn@latest add "https://reactbits.dev/r/[nama-komponen]"

# Atau copy manual dari reactbits.dev → paste ke Components/ReactBits/
```

Simpan semua file React Bits di:
```
resources/js/Components/ReactBits/
  AnimatedNumber.jsx
  SplitText.jsx
  BlurText.jsx
  CountUp.jsx
  ...
```

---

### Komponen yang Relevan untuk Project Management App

Berikut komponen React Bits yang paling berguna untuk konteks Techarea:

#### 1. `CountUp` — Angka Statistik Animasi
Cocok untuk: Dashboard stat cards (total project, total klien, revenue)

```jsx
// Setelah copy dari reactbits.dev ke Components/ReactBits/CountUp.jsx
import CountUp from '@/Components/ReactBits/CountUp';

// Di halaman Dashboard
<div className="grid grid-cols-3 gap-4">
  <div className="bg-card border border-border rounded-xl p-5">
    <p className="text-sm text-muted-foreground mb-1">Total Project</p>
    <CountUp
      from={0}
      to={stats.total_projects}
      duration={1.5}
      className="text-3xl font-bold text-foreground tabular-nums"
    />
  </div>
</div>
```

#### 2. `BlurText` — Heading Animasi Blur-in
Cocok untuk: Hero section, welcome screen, halaman kosong

```jsx
import BlurText from '@/Components/ReactBits/BlurText';

// Welcome screen pertama kali login
<BlurText
  text="Selamat datang di Techarea"
  className="text-display text-foreground"
  delay={100}
  animateBy="words"
/>
```

#### 3. `SplitText` — Teks Masuk Per Karakter/Kata
Cocok untuk: Page title di halaman penting, error 404

```jsx
import SplitText from '@/Components/ReactBits/SplitText';

<SplitText
  text="Dashboard"
  className="text-heading font-semibold"
  delay={50}
  animationFrom={{ opacity: 0, transform: 'translateY(20px)' }}
  animationTo={{ opacity: 1, transform: 'translateY(0)' }}
/>
```

#### 4. `AnimatedNumber` — Counter Real-time
Cocok untuk: Metric yang berubah (progress project, persentase)

```jsx
import AnimatedNumber from '@/Components/ReactBits/AnimatedNumber';

// Progress project
<div className="flex items-center gap-2">
  <AnimatedNumber value={project.progress} />
  <span className="text-sm text-muted-foreground">% selesai</span>
</div>
```

#### 5. `FadeContent` / `ScrollReveal` — Animasi Scroll
Cocok untuk: List project, card yang muncul saat scroll

```jsx
import ScrollReveal from '@/Components/ReactBits/ScrollReveal';

{projects.data.map((project, i) => (
  <ScrollReveal key={project.id} delay={i * 100}>
    <ProjectCard project={project} />
  </ScrollReveal>
))}
```

#### 6. `GradientText` — Teks Gradient Branded
Cocok untuk: Highlight kata kunci, badge khusus, empty state

```jsx
import GradientText from '@/Components/ReactBits/GradientText';

<h2 className="text-heading">
  Belum ada project.{' '}
  <GradientText
    colors={['#3d47e8', '#7589ff']}
    className="font-semibold"
  >
    Mulai sekarang.
  </GradientText>
</h2>
```

---

### Pattern yang Direkomendasikan

#### Dashboard Stats Card dengan CountUp

```jsx
// Components/App/StatCard.jsx
import CountUp from '@/Components/ReactBits/CountUp';
import { cn } from '@/Lib/utils';

export function StatCard({ label, value, prefix = '', suffix = '', icon: Icon, trend }) {
  return (
    <div className="bg-card border border-border rounded-xl p-5 shadow-card hover:shadow-card-hover transition-shadow">
      <div className="flex items-start justify-between mb-3">
        <p className="text-sm font-medium text-muted-foreground">{label}</p>
        {Icon && (
          <div className="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center">
            <Icon className="w-4 h-4 text-brand-600" />
          </div>
        )}
      </div>

      <div className="flex items-end gap-1">
        {prefix && <span className="text-lg font-medium text-foreground">{prefix}</span>}
        <CountUp
          from={0}
          to={value}
          duration={1.2}
          className="text-3xl font-bold text-foreground tabular-nums"
        />
        {suffix && <span className="text-lg font-medium text-muted-foreground">{suffix}</span>}
      </div>

      {trend && (
        <p className={cn('text-xs mt-2', trend > 0 ? 'text-green-600' : 'text-red-500')}>
          {trend > 0 ? '↑' : '↓'} {Math.abs(trend)}% dari bulan lalu
        </p>
      )}
    </div>
  );
}

// Pemakaian di Dashboard
<div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  <StatCard label="Total Project"   value={stats.projects}  icon={FolderOpen} trend={12} />
  <StatCard label="Aktif"           value={stats.active}    icon={Activity}   trend={5}  />
  <StatCard label="Klien"           value={stats.clients}   icon={Users}                 />
  <StatCard label="Selesai Bulan Ini" value={stats.completed} icon={CheckCircle} trend={-3} />
</div>
```

#### Empty State dengan BlurText

```jsx
// Components/App/EmptyState.jsx — versi dengan React Bits
import BlurText from '@/Components/ReactBits/BlurText';

export function EmptyState({ icon: Icon, title, description, action }) {
  return (
    <div className="flex flex-col items-center justify-center py-16 text-center">
      <div className="w-14 h-14 rounded-2xl bg-muted flex items-center justify-center mb-5">
        {Icon && <Icon className="w-7 h-7 text-muted-foreground" />}
      </div>

      <BlurText
        text={title}
        className="text-sm font-semibold text-foreground mb-1"
        delay={80}
        animateBy="words"
      />

      {description && (
        <p className="text-sm text-muted-foreground max-w-xs mt-1">{description}</p>
      )}

      {action && <div className="mt-5">{action}</div>}
    </div>
  );
}
```

---

### Aturan Penggunaan React Bits di Techarea

```
✅ Maksimal 2-3 animated component per halaman
✅ Selalu simpan file di Components/ReactBits/ — jangan taruh langsung di Pages
✅ Test di device low-end sebelum push — animasi bisa berat
✅ Sediakan fallback static jika animasi gagal load
✅ Disable animasi di mobile jika terasa janky (gunakan media query atau useReducedMotion)

❌ Jangan pakai React Bits di dalam loop besar (>20 item)
❌ Jangan animasi komponen yang di-render ulang sering (form field, table row)
❌ Jangan pakai background effect (Aurora, Blob, dll) di halaman data-heavy
❌ Jangan install sebagai npm dependency — copy code saja
```

---

## 14. Larangan Keras (Frontend)


```
❌ console.log() di production — hapus sebelum push
❌ Inline style ({{}}) kecuali nilai benar-benar dinamis (misal: width dari kalkulasi)
❌ Hardcode warna hex atau class arbitrary bg-[#xxx] — pakai token
❌ <a href="..."> untuk navigasi — pakai <Link> dari Inertia
❌ fetch/axios di useEffect untuk page load — kirim dari controller
❌ Tulis ulang komponen yang sudah ada di Components/ui/ atau Components/App/
❌ Komponen > 150 baris — pecah ke Partials/
❌ Logika bisnis (kalkulasi, transform data kompleks) di JSX — pindah ke Lib/utils.js atau custom hook
❌ String status / label hardcode di JSX — pakai constants.js
❌ Import langsung dari node_modules jika sudah ada wrapper di Components/
```

---

## 15. Checklist Sebelum Selesai

- [ ] Tidak ada `console.log` tertinggal
- [ ] Semua warna pakai token CSS variable shadcn/ui atau token Tailwind dari config
- [ ] Font Satoshi sudah load dan tampil dengan benar
- [ ] Navigasi pakai Inertia `Link` atau `router`
- [ ] Form pakai `useForm` dari Inertia, bukan state manual + axios
- [ ] Loading state (`processing`) ditampilkan saat form submit
- [ ] Error dari backend ditampilkan di field yang sesuai
- [ ] Responsive dicek di breakpoint `sm` (mobile) dan `lg` (desktop)
- [ ] Komponen reusable sudah di `Components/App/`, bukan duplikat per halaman
- [ ] Label / status sudah pakai `constants.js`
- [ ] Tidak ada hardcode string yang seharusnya dari konstanta
- [ ] React Bits: tidak lebih dari 2-3 animated component per halaman
- [ ] React Bits: file sudah disimpan di `Components/ReactBits/`, bukan inline di Page