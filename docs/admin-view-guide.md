# Panduan Admin View - Sistem Pengelolaan Barang Pamtech

## Daftar Isi
- [Dashboard](#dashboard)
- [Manajemen Barang (Items)](#manajemen-barang-items)
- [Kit Proyek (Templates)](#kit-proyek-templates)
- [Barang Keluar (Material Requests)](#barang-keluar-material-requests)
- [Laporan (Reports)](#laporan-reports)
- [Profil & Autentikasi](#profil--autentikasi)

---

## Dashboard

**Route:** `/dashboard`  
**View:** `dashboard.blade.php`

### Fitur Utama

#### 1. **Ringkasan Statistik**
Menampilkan 4 kartu statistik utama:
- **Total Barang** - jumlah semua item dalam inventori
- **Tools Tersedia** - jumlah alat yang tersedia untuk dipinjam
- **Proyek Aktif** - jumlah proyek yang sedang berjalan
- **Items Low Stock** - jumlah barang dengan stok menipis

#### 2. **Tab Navigation**
Dashboard memiliki 3 tab utama:

**📦 Tab Barang Keluar**
- Daftar semua material request yang sedang aktif
- Filter berdasarkan status (Pending, Checked Out, Returned, Closed)
- Aksi cepat: Lihat Detail, Checkout, Check-in
- Badge status berwarna untuk identifikasi cepat

**📋 Tab Riwayat Proyek**
- Menampilkan proyek yang sudah selesai (Closed)
- Dikelompokkan berdasarkan status final
- Informasi: Nama proyek, teknisi, tanggal, items
- **Sub-section:**
  - **Consumables** (Barang Habis Pakai)
  - **Tools** (Alat/Peralatan)

**📊 Tab Item Inventory**
- Daftar lengkap semua barang dalam gudang
- Informasi: Kode, Nama, Kategori, Stok, Unit, Harga
- Filter by kategori dan search functionality
- Link cepat ke halaman detail item

---

## Manajemen Barang (Items)

**Route:** `/items`  
**Views:** `items/index.blade.php`, `create.blade.php`, `edit.blade.php`

### Halaman Index (`/items`)

#### Fitur:
- **Tabel Item Lengkap** dengan kolom:
  - Kode Barang
  - Nama Barang
  - Kategori
  - Tipe (Tools/Consumables)
  - Stok Tersedia
  - Unit
  - Harga
  - Aksi (Edit, Delete)

- **Filter & Search:**
  - Search by nama atau kode
  - Filter by kategori
  - Filter by tipe (Tools/Consumables)

- **Badge Tipe:**
  - 🔧 **Tools** - Badge biru untuk alat
  - 📦 **Consumables** - Badge orange untuk barang habis pakai

- **Actions:**
  - ➕ Tambah Item Baru
  - ✏️ Edit Item
  - 🗑️ Hapus Item

### Halaman Create (`/items/create`)

#### Form Input:
1. **Kode Barang** - unique identifier
2. **Nama Barang** - nama item
3. **Kategori** - dropdown kategori
4. **Tipe** - Radio button (Tools/Consumables)
5. **Stok Awal** - jumlah stok
6. **Unit** - satuan (pcs, box, unit, dll)
7. **Harga** - harga per unit

### Halaman Edit (`/items/{id}/edit`)

Form yang sama dengan Create, tapi dengan data yang sudah terisi untuk di-update.

---

## Kit Proyek (Templates)

**Route:** `/templates`  
**Views:** `templates/index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php`

### Konsep Kit Proyek
Template/Kit adalah paket preset barang untuk jenis proyek tertentu. Memudahkan pembuatan material request dengan kombinasi barang yang sudah ditentukan.

### Halaman Index (`/templates`)

#### Fitur:
- **Daftar Template** dalam format card grid
- **Informasi per Template:**
  - Nama Template/Kit
  - Deskripsi singkat
  - Jumlah item dalam kit
  - Tanggal dibuat
- **Actions:**
  - 👁️ Lihat Detail
  - ✏️ Edit Template
  - 🗑️ Hapus Template

### Halaman Create (`/templates/create`)

#### Form Input:
1. **Nama Template** - nama kit/paket
2. **Deskripsi** - penjelasan tentang template
3. **Item List:**
   - Pilih item dari inventory
   - Tentukan quantity default
   - Bisa tambah/hapus item dalam kit

### Halaman Show (`/templates/{id}`)

#### Detail Template:
- Header: Nama & Deskripsi
- **Tabel Item dalam Kit:**
  - Nama Item
  - Kode Item
  - Quantity Default
  - Tipe (Tools/Consumables)
- Button: Use Template, Edit, Delete

---

## Barang Keluar (Material Requests)

**Route:** `/requests`  
**Views:** `requests/index.blade.php`, `create.blade.php`, `show.blade.php`, `checkin.blade.php`

### Halaman Index (`/requests`)

#### Fitur:
- **Daftar Semua Request** dengan info:
  - Nama Proyek
  - Teknisi
  - Status (Badge berwarna)
  - Tanggal
  - Jumlah Items
  - Actions

- **Filter Status:**
  - 🟡 Pending - Menunggu approval
  - 🔵 Checked Out - Barang sudah keluar
  - 🟣 Returned - Barang dikembalikan, menunggu rekonsiliasi
  - 🟢 Closed - Proyek selesai

- **Quick Actions:**
  - Detail Proyek
  - Approve & Checkout
  - Check-in
  - Edit Rekonsiliasi

### Halaman Create (`/requests/create`)

#### Alur Pembuatan Request:

**Step 1: Informasi Proyek**
1. Nama Proyek
2. Nama Teknisi
3. Lokasi Proyek
4. Tanggal Mulai
5. Estimasi Durasi
6. Pilih Template (Optional)

**Step 2: Pilih Items**
- Modal picker untuk memilih barang
- Grouped by kategori
- Search functionality
- Quantity input untuk setiap item

**Step 3: Review & Submit**
- Ringkasan proyek
- Daftar items yang akan keluar
- Submit untuk create request

### Halaman Show (`/requests/{id}`)

#### Detail Material Request:

**Info Header:**
- Nama Proyek & Status Badge
- Teknisi & Lokasi
- Tanggal & Durasi
- Actions berdasarkan status

**Tabel Items:**
- Nama Barang
- Kode
- Qty Keluar
- Tipe
- Status Checkout/Return

**Timeline:**
- Created - tanggal request dibuat
- Checked Out - tanggal barang keluar
- Checked In - tanggal barang kembali
- Closed - tanggal proyek selesai

**Actions Berdasarkan Status:**
- Status **Pending**: Approve & Checkout
- Status **Checked Out**: Check-in
- Status **Returned**: Edit Rekonsiliasi, Close Project
- Status **Closed**: View Only

### Halaman Checkout

#### Proses Checkout:
Saat admin approve request dan checkout barang:
1. Verifikasi stok tersedia
2. Update stok barang
3. Record qty_out untuk setiap item
4. Update status request → `CHECKED_OUT`
5. Redirect ke detail request

### Halaman Check-in (`/requests/{id}/checkin`)

#### Proses Rekonsiliasi:

**Background Hijau Mint** (#f0fdf4) untuk user experience yang nyaman

**Form Check-in untuk Setiap Item:**

Tampilan **horizontal layout:**
- **Nama Barang** + QR Scanner Button
- **Terpakai** - jumlah yang digunakan/habis
- **Kembali** - jumlah yang dikembalikan
- **Rusak** - jumlah yang rusak
- **Hilang** - jumlah yang hilang

**Optional Fields:**
- Catatan (Notes) - penjelasan tambahan
- Foto Bukti - upload foto kondisi barang

**Validasi:**
- Total = Terpakai + Kembali + Rusak + Hilang
- Must equal qty_out
- Tools: qty_used selalu 0 (karena tidak habis pakai)

**Submit Check-in:**
1. Update qty_returned, qty_used, qty_damaged, qty_lost
2. Update stok di inventory
3. Set status → `RETURNED`
4. Redirect berdasarkan role (Admin/Technician)

### Edit Rekonsiliasi (`/requests/{id}/reconciliation/edit`)

Admin bisa edit hasil rekonsiliasi jika ada kesalahan input sebelum close project.

---

## Laporan (Reports)

**Route:** `/reports`  
**Views:** `reports/index.blade.php`, `loss-damage.blade.php`, `stock-movement.blade.php`, `tool-utilization.blade.php`

### Halaman Index (`/reports`)

Hub untuk akses semua laporan dengan 3 kartu navigasi:

### 1. Laporan Loss & Damage (`/reports/loss-damage`)

#### Fitur:
- **Filter:**
  - Rentang tanggal
  - Tipe item (Tools/Consumables)
  - Kategori

- **Tabel Report:**
  - Nama Proyek
  - Teknisi
  - Item
  - Qty Rusak
  - Qty Hilang
  - Nilai Kerugian (Qty × Harga)
  - Tanggal

- **Summary:**
  - Total Rusak
  - Total Hilang
  - Total Nilai Kerugian

- **Export:** PDF

### 2. Laporan Stock Movement (`/reports/stock-movement`)

#### Fitur:
- **Filter:**
  - Rentang tanggal
  - Kategori
  - Tipe transaksi (In/Out)

- **Tabel Movement:**
  - Tanggal
  - Item
  - Tipe Transaksi
  - Qty
  - Stok Sebelum
  - Stok Sesudah
  - Reference (Request ID/Proyek)

- **Summary:**
  - Total In
  - Total Out
  - Current Stock

- **Export:** PDF

### 3. Laporan Tool Utilization (`/reports/tool-utilization`)

#### Fitur:
- **Filter:**
  - Rentang tanggal
  - Kategori tools

- **Metrics:**
  - **Frequency** - berapa kali tool dipakai
  - **Days Out** - total hari tool berada di luar
  - **Utilization Rate** - persentase penggunaan

- **Tabel Utilization:**
  - Nama Tool
  - Kode
  - Total Penggunaan
  - Total Hari Keluar
  - Avg Hari per Proyek
  - Utilization %

- **Chart:** Bar chart utilization (optional)

- **Export:** PDF

### PDF Export

Semua laporan bisa di-export ke PDF dengan:
- Header: Logo Pamtechno + Info Perusahaan
- Filter yang digunakan
- Tabel data lengkap
- Summary/Total
- Footer: Tanggal cetak

---

## Profil & Autentikasi

### Login (`/login`)
- Email & Password
- Remember Me
- Link reset password

### Register (`/register`)
- Name, Email, Password
- Role (Admin/Technician)

### Profile (`/profile`)
- Edit profile information
- Update password
- Account settings

---

## Navigasi & Layout

### Sidebar Navigation (Admin)

**Main Menu:**
1. 📊 **Dashboard** - overview & statistik
2. 📦 **Barang Keluar** - material requests
3. 🧰 **Kit Proyek** - templates
4. 📋 **Inventori** - item management
5. 📈 **Laporan** - reports hub

**Bottom Menu:**
- ⚙️ Settings
- 🚪 Logout

### Header
- Logo Pamtechno
- Current route breadcrumb
- User info & avatar
- Notifications (if any)

---

## Alur Kerja Admin

### Alur 1: Setup Item & Template
```
1. Tambah Items → /items/create
2. Buat Template/Kit → /templates/create
3. Assign items ke template
```

### Alur 2: Proses Material Request
```
1. Teknisi buat request → Status: Pending
2. Admin review & approve → Checkout
3. Barang keluar → Status: Checked Out
4. Proyek selesai → Teknisi check-in
5. Status: Returned
6. Admin review rekonsiliasi → Close project
7. Status: Closed
```

### Alur 3: Monitoring & Reporting
```
1. Dashboard → lihat statistik real-time
2. Reports → analisis loss/damage
3. Reports → track stock movement
4. Reports → evaluasi tool utilization
5. Export PDF untuk dokumentasi
```

---

## Teknologi & Komponen

### Backend
- **Laravel 12** - PHP Framework
- **MySQL** - Database
- **Eloquent ORM** - Data modeling

### Frontend
- **Blade Templates** - View engine
- **Tailwind CSS** - Styling
- **Alpine.js** - Interaktivity
- **Vite** - Asset bundling

### Components
- **Barcode Scanner** - untuk check-in cepat
- **Modal** - item picker
- **Tabs** - dashboard navigation
- **Charts** - visualization (optional)

---

## Best Practices

### Untuk Admin:
1. **Selalu review rekonsiliasi** sebelum close project
2. **Monitor low stock items** di dashboard
3. **Export laporan berkala** untuk dokumentasi
4. **Update harga item** jika ada perubahan
5. **Backup template** untuk proyek berulang

### Security:
- Role-based access control (Admin/Technician)
- CSRF protection
- Input validation
- Secure file uploads

---

## Screenshots Highlights

> **Note:** Beberapa fitur visual penting:
> - Badge berwarna untuk status (Pending=Kuning, Checked Out=Biru, dll)
> - Background hijau mint (#f0fdf4) pada halaman check-in
> - QR Scanner icon untuk fitur barcode
> - Responsive design untuk mobile dan desktop

---

## Support & Troubleshooting

### Jika ada masalah:
1. Check logs di `storage/logs/laravel.log`
2. Verify database connection di `.env`
3. Clear cache: `php artisan cache:clear`
4. Restart server jika perlu

### Contact:
- Developer: Pamtechno Team
- Version: 1.0.0
- Last Updated: February 2026
