# Rancangan Database - Sistem Pengelolaan Barang Pamtechno

Dokumen ini menjelaskan struktur database (Schema) untuk Sistem Pengelolaan Barang Pamtechno berdasarkan **implementasi aktual**.

---

## Entity Relationship Diagram (ERD) Overview

Sistem ini terdiri dari entitas utama:
- **Master Data**: `users`, `categories`, `items`, `project_templates`
- **Transaksi**: `material_requests`, `material_request_items`

---

## Detail Tabel

### 1. `users` (Tabel Pengguna)
*Bawaan Laravel dengan penyesuaian role.*

| Column | Type | Description |
|--------|------|-------------|
| `id` | BigInt, PK | Primary key |
| `name` | String | Nama lengkap user |
| `email` | String, Unique | Email untuk login |
| `password` | String | Hashed password |
| `role` | String/Enum | 'admin' atau 'technician' |
| `created_at` | Timestamp | Tanggal dibuat |
| `updated_at` | Timestamp | Tanggal update terakhir |

**Roles:**
- `admin`: Akses penuh (CRUD items, approve, checkout, close project, reports)
- `technician`: Limited (create request, check-in, view inventory)

---

### 2. `categories` (Kategori Barang)

| Column | Type | Description |
|--------|------|-------------|
| `id` | BigInt, PK | Primary key |
| `name` | String | Nama kategori (misal: "Elektrikal", "Hand Tools") |
| `description` | Text, Nullable | Deskripsi kategori |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

**Contoh Data:**
- Elektrikal
- Hand Tools
- CCTV Equipment
- Access Control
- Networking

---

### 3. `items` (Master Barang)

| Column | Type | Description |
|--------|------|-------------|
| `id` | BigInt, PK | Primary key |
| `category_id` | BigInt, FK | Kategori barang (→ categories) |
| `code` | String, Unique | Kode barang/SKU (misal: "KABEL-001") |
| `name` | String | Nama barang |
| `type` | Enum | 'tools' atau 'consumables' |
| `stock` | Integer | Stok tersedia di gudang |
| `unit` | String | Satuan (m, pcs, box, roll, set, dll) |
| `price` | Decimal(10,2) | Harga per unit |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

**Type Logic:**
- `tools`: Alat yang tidak habis pakai, dikembalikan (Tang, Obeng, Mesin Bor, dll)
  - `qty_used` selalu 0 saat check-in
  - Must return atau mark sebagai rusak/hilang
- `consumables`: Barang habis pakai (Kabel, BNC, Isolasi, Sekrup, dll)
  - `qty_used` > 0 saat check-in
  - Tidak perlu dikembalikan

**Stock Mutation:**
- Saat **checkout**: `stock -= qty_out`
- Saat **check-in**: `stock += qty_returned`
- Rusak/Hilang: Tidak menambah stok kembali

---

### 4. `project_templates` (Template/Kit Proyek)

| Column | Type | Description |
|--------|------|-------------|
| `id` | BigInt, PK | Primary key |
| `name` | String | Nama template (misal: "Instalasi CCTV 4 Channel") |
| `description` | Text, Nullable | Deskripsi template |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

**Purpose:**
Pre-defined kombinasi barang untuk jenis proyek tertentu. Mempercepat pembuatan material request.

---

### 5. `template_items` (Item dalam Template)

| Column | Type | Description |
|--------|------|-------------|
| `id` | BigInt, PK | Primary key |
| `template_id` | BigInt, FK | Template (→ project_templates) |
| `item_id` | BigInt, FK | Barang (→ items) |
| `quantity` | Integer | Default quantity yang disarankan |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

**Usage Flow:**
1. Admin pilih template saat buat request
2. System auto-populate items dari template_items
3. Admin/Teknisi bisa adjust quantity sebelum submit

---

### 6. `material_requests` (Proyek / Permintaan Barang)

| Column | Type | Description |
|--------|------|-------------|
| `id` | BigInt, PK | Primary key |
| `project_name` | String | Nama proyek |
| `technician_name` | String | Nama teknisi penanggung jawab |
| `project_location` | String | Lokasi proyek |
| `start_date` | Date | Tanggal mulai proyek |
| `duration_days` | Integer | Estimasi durasi (hari) |
| `template_id` | BigInt, FK, Nullable | Template yang digunakan (→ project_templates) |
| `status` | Enum | Status request (lihat detail di bawah) |
| `created_by` | BigInt, FK | User yang membuat (→ users) |
| `checked_out_at` | Timestamp, Nullable | Waktu checkout |
| `checked_out_by` | BigInt, FK, Nullable | Admin yang checkout (→ users) |
| `checked_in_at` | Timestamp, Nullable | Waktu check-in |
| `closed_at` | Timestamp, Nullable | Waktu project closed |
| `closed_by` | BigInt, FK, Nullable | Admin yang close (→ users) |
| `notes` | Text, Nullable | Catatan tambahan |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

**Status Enum:**
```php
const STATUS_PENDING = 'pending';
const STATUS_CHECKED_OUT = 'checked_out';
const STATUS_RETURNED = 'returned';
const STATUS_CLOSED = 'closed';
```

**Status Lifecycle:**
```
PENDING → CHECKED_OUT → RETURNED → CLOSED
```

1. **PENDING**: Request dibuat, menunggu admin approve & checkout
2. **CHECKED_OUT**: Admin approve, barang sudah keluar dari gudang
3. **RETURNED**: Teknisi sudah check-in, menunggu admin verify & close
4. **CLOSED**: Project selesai, rekonsiliasi verified

---

### 7. `material_request_items` (Detail Barang per Request)

| Column | Type | Description |
|--------|------|-------------|
| `id` | BigInt, PK | Primary key |
| `material_request_id` | BigInt, FK | Request (→ material_requests) |
| `item_id` | BigInt, FK | Barang (→ items) |
| `qty_out` | Integer | Jumlah barang yang keluar saat checkout |
| `qty_used` | Integer, Default 0 | Jumlah terpakai (consumables) |
| `qty_returned` | Integer, Default 0 | Jumlah dikembalikan (tools) |
| `qty_damaged` | Integer, Default 0 | Jumlah rusak |
| `qty_lost` | Integer, Default 0 | Jumlah hilang |
| `condition_out` | String, Default 'good' | Kondisi saat keluar |
| `condition_in` | String, Nullable | Kondisi saat kembali ('good', 'damaged', 'lost') |
| `notes` | Text, Nullable | Catatan per item |
| `photo_path` | String, Nullable | Path foto bukti (jika ada rusak/hilang) |
| `created_at` | Timestamp | |
| `updated_at` | Timestamp | |

**Validation Rule (Check-in):**
```
qty_used + qty_returned + qty_damaged + qty_lost = qty_out
```

**For Tools:**
- `qty_used` = 0 (karena tidak habis pakai)
- `qty_returned` = jumlah yang dikembalikan dalam kondisi baik
- `qty_damaged` = jumlah yang rusak
- `qty_lost` = jumlah yang hilang

**For Consumables:**
- `qty_used` = jumlah yang dipakai/habis
- `qty_returned` = jumlah sisa yang dikembalikan
- `qty_damaged` = jumlah yang rusak sebelum dipakai
- `qty_lost` = jumlah yang hilang

---

## Relasi (Relationships)

### Users
- **hasMany**: `material_requests` (via `created_by`)
- **hasMany**: `material_requests` (via `checked_out_by`)
- **hasMany**: `material_requests` (via `closed_by`)

### Categories
- **hasMany**: `items`

### Items
- **belongsTo**: `category`
- **hasMany**: `template_items`
- **hasMany**: `material_request_items`

### ProjectTemplates
- **hasMany**: `template_items`
- **hasMany**: `material_requests`

### MaterialRequests
- **belongsTo**: `user` (creator)
- **belongsTo**: `user` (checker_outer)
- **belongsTo**: `user` (closer)
- **belongsTo**: `project_template`
- **hasMany**: `material_request_items`

### MaterialRequestItems
- **belongsTo**: `material_request`
- **belongsTo**: `item`

---

## Query Examples

### 1. Get Active Projects for Technician
```php
$activeProjects = MaterialRequest::with(['template', 'items.item'])
    ->where(function($query) use ($user) {
        $query->where('created_by', $user->id)
              ->orWhere('technician_name', $user->name);
    })
    ->whereIn('status', [
        MaterialRequest::STATUS_PENDING,
        MaterialRequest::STATUS_CHECKED_OUT,
        MaterialRequest::STATUS_RETURNED
    ])
    ->latest()
    ->get();
```

### 2. Get Completed Projects
```php
$completedProjects = MaterialRequest::with(['template', 'items.item'])
    ->where('created_by', $user->id)
    ->where('status', MaterialRequest::STATUS_CLOSED)
    ->latest()
    ->take(5)
    ->get();
```

### 3. Stock Movement on Checkout
```php
foreach ($items as $item) {
    $itemModel = Item::find($item['item_id']);
    $itemModel->decrement('stock', $item['quantity']);
}
```

### 4. Stock Movement on Check-in
```php
foreach ($items as $item) {
    $itemModel = Item::find($item['item_id']);
    $itemModel->increment('stock', $item['qty_returned']);
}
```

### 5. Items with Low Stock
```php
$lowStock = Item::whereColumn('stock', '<=', DB::raw('min_stock'))
    ->orWhere('stock', '<=', 10)
    ->get();
```

---

## Indexes & Performance

**Recommended Indexes:**
```sql
-- items table
CREATE INDEX idx_items_code ON items(code);
CREATE INDEX idx_items_category ON items(category_id);
CREATE INDEX idx_items_type ON items(type);

-- material_requests table
CREATE INDEX idx_requests_status ON material_requests(status);
CREATE INDEX idx_requests_created_by ON material_requests(created_by);
CREATE INDEX idx_requests_technician ON material_requests(technician_name);

-- material_request_items table
CREATE INDEX idx_request_items_request ON material_request_items(material_request_id);
CREATE INDEX idx_request_items_item ON material_request_items(item_id);
```

---

## Data Integrity Rules

### On Checkout:
1. Verify `item.stock >= qty_out` untuk semua items
2. Update `material_requests.status` = 'checked_out'
3. Set `checked_out_at` dan `checked_out_by`
4. Decrement `items.stock` untuk semua items

### On Check-in:
1. Validate `qty_used + qty_returned + qty_damaged + qty_lost = qty_out`
2. Update `material_requests.status` = 'returned'
3. Set `checked_in_at`
4. Update all `material_request_items` fields
5. **Do NOT** update stock yet (menunggu admin close)

### On Close Project:
1. Verify rekonsiliasi data
2. Update `material_requests.status` = 'closed'
3. Set `closed_at` dan `closed_by`
4. Increment `items.stock` dengan `qty_returned` untuk setiap item
5. Log rusak/hilang untuk reporting

---

## Migrations Structure

**Migration Files:**
1. `create_categories_table`
2. `create_items_table`
3. `create_project_templates_table`
4. `create_template_items_table`
5. `create_material_requests_table`
6. `create_material_request_items_table`

**Seeder:**
- `CategorySeeder`: Seed kategori standar
- `ItemSeeder`: Seed sample items (optional)
- `UserSeeder`: Seed admin & technician users

---

## Schema Version
- **Version**: 1.0
- **Last Updated**: February 2026
- **Laravel Version**: 12.x
- **Database**: MySQL 8.0+ / MariaDB 10.5+
