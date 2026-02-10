# Rancangan Implementasi Frontend - Sistem Pengelolaan Barang Pamtechno

Dokumen ini menjelaskan strategi implementasi antarmuka (UI/UX) untuk Sistem Pengelolaan Barang Pamtechno berdasarkan **implementasi aktual**, dengan fokus pada estetika modern, kemudahan penggunaan (Mobile-First untuk teknisi), dan interaktivitas.

---

## 1. Stack Teknologi

### Core
- **Template Engine**: Laravel Blade Components
- **CSS Framework**: Tailwind CSS (Latest v3.x)
- **JavaScript**: Alpine.js untuk interaktivity
- **Asset Bundling**: Vite
- **Icons**: Heroicons (SVG inline)

### Libraries
- **PDF Export**: DomPDF
- **Barcode/QR**: HTML5 Scanner (future)
- **Charts**: Chart.js (optional untuk reporting)

### Font
- **Primary**: Inter (Modern & Clean)
- **Fallback**: System fonts

---

## 2. Design System

### Color Palette

**Admin View:**
```css
Primary: #006600 (Green)
Background: #FFFFFF (White)
Text: Slate (800, 700, 600, 500)
Borders: Slate-200, Slate-300
```

**Technician View:**
```css
Primary: #006600 (Green)
Background: #f0fdf4 (Mint Green) untuk check-in
Background: #FAFAFA (Light Gray) untuk dashboard
Text: Slate (800, 700, 600, 500)
```

**Status Colors:**
```css
Pending: #FCD34D (Yellow)
Checked Out: #3B82F6 (Blue)
Returned: #A855F7 (Purple)
Closed: #10B981 (Green)
Error/Danger: #EF4444 (Red)
```

### Typography
- **Headers**: font-bold, text-2xl/xl/lg
- **Body**: font-regular, text-base/sm
- **Buttons**: font-semibold
- **Monospace**: Code/SKU dalam font-mono

### Spacing & Sizing
- Container: max-w-7xl
- Cards: p-6, rounded-2xl
- Buttons: px-4 py-2, rounded-lg
- Input: px-3 py-2, rounded-lg
- Gap: gap-4, gap-6 untuk section

### Effects
- **Shadows**: shadow-sm, shadow-md untuk cards
- **Hover**: hover:bg-slate-50, transition-colors
- **Focus**: focus:ring-2 focus:ring-[#006600]
- **Rounded**: rounded-xl, rounded-2xl
- **Borders**: border-2 untuk emphasis

---

## 3. Layouts

### A. Admin Layout (`layouts/app.blade.php`)

```
┌─────────────────────────────────────┐
│ [Sidebar]  │  [Main Content]        │
│            │                        │
│ • Dashboard│  [Breadcrumb]          │
│ • Barang   │                        │
│   Keluar   │  [Page Content]        │
│ • Kit      │                        │
│   Proyek   │                        │
│ • Inventori│                        │
│ • Laporan  │                        │
│            │                        │
│ [Profile]  │  [Footer]              │
└─────────────────────────────────────┘
```

**Features:**
- Sticky sidebar (kiri)
- Collapsible navigation
- Logo Pamtechno di top sidebar
- User info & logout di bottom
- Breadcrumb navigation
- Responsive: Sidebar collapse di mobile

### B. Technician Layout (`layouts/technician.blade.php`)

```
┌─────────────────────────────────────┐
│ [Header - Logo + Profile]           │
├─────────────────────────────────────┤
│                                     │
│         [Main Content]              │
│     (No Sidebar - Fullscreen)       │
│                                     │
│                                     │
└─────────────────────────────────────┘
```

**Features:**
- No sidebar - fokus konten
- Simple header dengan logo
- Mobile-optimized
- Fullscreen untuk check-in
- Touch-friendly buttons (min 44px)

---

## 4. Page Details

### A. Admin Pages

#### 1. Dashboard (`dashboard.blade.php`)

**Stats Cards (4 kolom):**
```html
<div class="grid grid-cols-4 gap-6">
  <div class="bg-white rounded-xl shadow p-6">
    <h3>Total Barang</h3>
    <p class="text-3xl font-bold">{{ $totalItems }}</p>
  </div>
  <!-- 3 more cards -->
</div>
```

**Tabs (3 tabs):**
1. **Barang Keluar**: Daftar material requests aktif
2. **Riwayat Proyek**: Completed projects (grouped: consumables/tools)
3. **Item Inventory**: All items dengan filter

**Features:**
- Badge berwarna untuk status
- Quick actions per card
- Real-time search/filter

#### 2. Items Management (`items/index.blade.php`)

**Layout:**
```html
<div class="flex justify-between mb-6">
  <input type="search" placeholder="Search...">
  <button>+ Tambah Barang</button>
</div>

<table class="w-full">
  <thead class="bg-slate-50">
    <tr>
      <th>Kode</th>
      <th>Nama</th>
      <th>Kategori</th>
      <th>Tipe</th>
      <th>Stok</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <!-- Item rows -->
  </tbody>
</table>
```

**Badge Tipe:**
- Tools: Blue badge
- Consumables: Orange badge

#### 3. Template Editor (`templates/create.blade.php`)

**Alpine.js Repeater:**
```html
<div x-data="templateEditor()">
  <input type="text" x-model="name" placeholder="Nama Template">
  
  <h3>Items dalam Template</h3>
  
  <template x-for="(item, index) in items">
    <div class="flex gap-4">
      <select x-model="item.item_id">
        <option>-- Pilih Item --</option>
      </select>
      <input type="number" x-model="item.quantity">
      <button @click="removeItem(index)">🗑️</button>
    </div>
  </template>
  
  <button @click="addItem()">+ Tambah Item</button>
</div>
```

#### 4. Material Request Create (`requests/create.blade.php`)

**Multi-step Form:**
```
Step 1: Project Info
  ↓
Step 2: Select Template (optional)
  ↓
Step 3: Select Items + Quantity
  ↓
Step 4: Review & Submit
```

**Item Picker Modal:**
```html
<div x-data="{ open: false }">
  <button @click="open = true">+ Tambah Barang</button>
  
  <div x-show="open" class="modal">
    <div class="modal-content">
      <input type="search" placeholder="Search items...">
      
      <template x-for="category in categories">
        <div>
          <h4>{{ category.name }}</h4>
          <template x-for="item in category.items">
            <div @click="selectItem(item)">
              {{ item.name }} ({{ item.stock }} {{ item.unit }})
            </div>
          </template>
        </div>
      </template>
    </div>
  </div>
</div>
```

#### 5. Check-in (`requests/checkin.blade.php`)

**Background:** Hijau Mint (#f0fdf4)

**Layout Per Item:**
```html
<div class="bg-white rounded-xl p-4 mb-4">
  <div class="flex items-center gap-3">
    <!-- Item Info (30%) -->
    <div class="flex-1">
      <div class="flex items-center gap-2">
        <span class="font-bold">{{ $item->name }}</span>
        <button class="qr-scanner">🔍</button>
      </div>
      <small>{{ $item->code }} • Badge • Qty: {{ $qtyOut }}</small>
    </div>
    
    <!-- Input Fields (70%) - Horizontal -->
    <div class="flex gap-3">
      <div>
        <label>Terpakai</label>
        <input type="number" name="qty_used">
      </div>
      <div>
        <label>Kembali</label>
        <input type="number" name="qty_returned">
      </div>
      <div>
        <label>Rusak</label>
        <input type="number" name="qty_damaged">
      </div>
      <div>
        <label>Hilang</label>
        <input type="number" name="qty_lost">
      </div>
    </div>
  </div>
  
  <!-- Expandable: Notes & Photo -->
  <div x-data="{ open: false }">
    <button @click="open = !open">Catatan & Foto</button>
    <div x-show="open">
      <textarea name="notes"></textarea>
      <input type="file" name="photo">
    </div>
  </div>
</div>
```

### B. Technician Pages

#### 1. Dashboard (`technician/dashboard.blade.php`)

**Simple Header:**
```html
<div class="mb-4 flex justify-between">
  <div>
    <h1>Halo, {{ Auth::user()->name }}</h1>
    <p>Dashboard Teknisi Pamtechno</p>
  </div>
  <div class="flex gap-2">
    <a href="/items">📦 Lihat Barang</a>
    <a href="/requests/create">+ Proyek Baru</a>
  </div>
</div>
```

**Proyek Aktif Section:**
```html
<h2>Proyek Aktif</h2>

@if($activeProjects->count() > 0)
  @foreach($activeProjects as $project)
    <div x-data="{ expanded: false }" class="project-card">
      <div @click="expanded = !expanded">
        <h3>{{ $project->project_name }}</h3>
        <span class="badge">{{ $project->status }}</span>
        <p>{{ $project->location }} • {{ $project->start_date }}</p>
      </div>
      
      <div x-show="expanded">
        <!-- Item list -->
        <a href="/projects/{{ $project->id }}">Detail Lengkap</a>
      </div>
    </div>
  @endforeach
@else
  <div class="empty-state">
    <p>Tidak ada proyek aktif</p>
    <a href="/requests/create">+ Buat Proyek Baru</a>
  </div>
@endif
```

**Riwayat Selesai:**
```html
<div class="mt-6">
  <h3>✅ Riwayat Selesai</h3>
  @foreach($completedProjects as $project)
    <div class="completed-card">
      <span>{{ $project->project_name }}</span>
      <span class="badge-green">Selesai</span>
    </div>
  @endforeach
</div>
```

#### 2. Create Request (`technician/create-request.blade.php`)

**Simplified Form:**
- Mobile-friendly input
- Template dropdown
- Item modal picker
- Large submit button

#### 3. Check-in (`technician/checkin.blade.php`)

Same struktur dengan admin tapi:
- Background mint green
- No breadcrumb
- Simpler navigation
- Bigger touch targets

---

## 5. Components

### Reusable Blade Components

#### 1. Status Badge (`components/status-badge.blade.php`)
```blade
@props(['status'])

@php
$colors = [
    'pending' => 'bg-yellow-100 text-yellow-800',
    'checked_out' => 'bg-blue-100 text-blue-800',
    'returned' => 'bg-purple-100 text-purple-800',
    'closed' => 'bg-green-100 text-green-800',
];
@endphp

<span {{ $attributes->merge(['class' => 'px-2 py-1 rounded text-xs font-medium ' . $colors[$status]]) }}>
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
```

#### 2. Type Badge (`components/type-badge.blade.php`)
```blade
@props(['type'])

@if($type === 'tools')
    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-xs">🔧 Tools</span>
@else
    <span class="px-2 py-0.5 bg-orange-100 text-orange-700 rounded text-xs">📦 Consumables</span>
@endif
```

---

## 6. Interactive Features

### Alpine.js Examples

#### 1. Quantity Validation (Check-in)
```javascript
function itemReconciliation() {
    return {
        qtyOut: 10,
        qtyUsed: 0,
        qtyReturned: 0,
        qtyDamaged: 0,
        qtyLost: 0,
        get total() {
            return this.qtyUsed + this.qtyReturned + this.qtyDamaged + this.qtyLost;
        },
        get isValid() {
            return this.total === this.qtyOut;
        }
    }
}
```

#### 2. Template Item Manager
```javascript
function templateEditor() {
    return {
        name: '',
        items: [],
        addItem() {
            this.items.push({ item_id: '', quantity: 1 });
        },
        removeItem(index) {
            this.items.splice(index, 1);
        }
    }
}
```

---

## 7. Mobile Optimization

### Responsive Breakpoints
```css
sm: 640px
md: 768px
lg: 1024px
xl: 1280px
```

### Mobile-Specific
- Sidebar collapse di < 1024px
- Touch-friendly buttons (min 44x44px)
- Numeric keyboard untuk qty input
- Camera access untuk photo upload
- Swipe gestures untuk tabs

---

## 8. Accessibility

- Semantic HTML (header, nav, main, footer)
- ARIA labels untuk icons
- Keyboard navigation
- Focus states jelas
- Alt text untuk images
- Color contrast WCAG AA

---

## 9. File Structure

```
resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php              # Admin
│   │   └── technician.blade.php       # Technician
│   ├── components/
│   │   ├── status-badge.blade.php
│   │   ├── type-badge.blade.php
│   │   └── barcode-scanner.blade.php
│   ├── dashboard.blade.php
│   ├── items/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── templates/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   ├── requests/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── show.blade.php
│   │   ├── checkin.blade.php
│   │   └── edit-reconciliation.blade.php
│   ├── technician/
│   │   ├── dashboard.blade.php
│   │   ├── create-request.blade.php
│   │   ├── show-project.blade.php
│   │   ├── checkin.blade.php
│   │   └── items.blade.php
│   └── reports/
│       ├── index.blade.php
│       ├── loss-damage.blade.php
│       ├── stock-movement.blade.php
│       └── tool-utilization.blade.php
├── css/
│   └── app.css
└── js/
    └── app.js
```

---

## 10. Performance

### Optimization
- Vite code splitting
- Lazy load images
- Minimize reflows
- Debounce search input
- Cache template data

### Build
```bash
npm run build     # Production
npm run dev       # Development with HMR
```

---

## Version
- **Frontend Version**: 1.0
- **Last Updated**: February 2026
- **Tailwind**: v3.x
- **Alpine.js**: v3.x
