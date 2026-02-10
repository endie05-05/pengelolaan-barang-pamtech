# Panduan Teknisi View - Sistem Pengelolaan Barang Pamtech

## Daftar Isi
- [Overview](#overview)
- [Dashboard Teknisi](#dashboard-teknisi)
- [Buat Proyek Baru](#buat-proyek-baru)
- [Detail Proyek](#detail-proyek)
- [Check-in Barang](#check-in-barang)
- [Lihat Inventori Barang](#lihat-inventori-barang)
- [Navigasi & UI](#navigasi--ui)
- [Alur Kerja Teknisi](#alur-kerja-teknisi)

---

## Overview

Interface teknisi dirancang **simple, mobile-friendly, dan fokus** pada operasional proyek. Berbeda dengan admin yang memiliki banyak fitur manajemen, teknisi hanya memiliki akses ke fitur-fitur yang diperlukan untuk:
1. Membuat permintaan barang proyek
2. Melihat proyek aktif
3. Check-in barang setelah proyek selesai
4. Melihat inventori barang tersedia

### Prinsip Desain
- ✅ **No Sidebar** - fullscreen untuk fokus maksimal
- ✅ **Mobile-First** - optimized untuk smartphone
- ✅ **Background Hijau Mint** (#f0fdf4) untuk kenyamanan mata
- ✅ **Minimal Navigation** - hanya fitur essensial
- ✅ **Quick Actions** - tombol aksi jelas dan besar

---

## Dashboard Teknisi

**Route:** `/technician/dashboard`  
**View:** `technician/dashboard.blade.php`

### Tampilan Utama

#### Header
```
┌─────────────────────────────────────┐
│ 🏢 Pamtechno                        │
│                                     │
│ Halo, [Nama Teknisi]                │
│ Dashboard Teknisi Pamtechno         │
│                                     │
│ [📦 Lihat Barang] [+ Proyek Baru]   │
└─────────────────────────────────────┘
```

**Action Buttons:**
- **📦 Lihat Barang** - Link ke halaman inventori
- **➕ Proyek Baru** - Button hijau untuk buat project baru

#### Content Area

**Tab: Proyek Aktif** (Tab tunggal, tidak ada Laporan)

Menampilkan semua proyek yang sedang berjalan:

**Kartu Proyek (Expandable):**
```
┌─────────────────────────────────────┐
│ 📋 Nama Proyek                      │
│ 📍 Lokasi • 🟡 Status Badge         │
│ 📅 Tanggal • ⏱️ Durasi              │
│                                     │
│ [▼ Lihat Detail]                    │
│                                     │
│ [Expanded Content:]                 │
│ • Daftar Items (Consumables/Tools)  │
│ • Qty Keluar                        │
│ • Quick Actions:                    │
│   - [🔍 Detail Lengkap]             │
│   - [✅ Check-in] (jika Checked Out)│
└─────────────────────────────────────┘
```

**Status Badge Colors:**
- 🟡 **Pending** - Kuning (Menunggu approval admin)
- 🔵 **Checked Out** - Biru (Barang sudah keluar, proyek berjalan)
- 🟣 **Returned** - Ungu (Sudah check-in, menunggu admin close)

**Empty State:**
Jika tidak ada proyek aktif:
```
┌─────────────────────────────────────┐
│         📦                          │
│   Tidak ada proyek aktif            │
│   Anda belum memiliki proyek yang   │
│   sedang berjalan.                  │
│                                     │
│   [+ Buat Proyek Baru]              │
└─────────────────────────────────────┘
```

#### Riwayat Selesai

**Tampil di bawah Proyek Aktif** (walaupun tidak ada proyek aktif)

```
┌─────────────────────────────────────┐
│ ✅ Riwayat Selesai                  │
│                                     │
│ • Project Alpha (Selesai) 10 Feb    │
│ • Project Beta (Selesai) 08 Feb     │
│ • Project Gamma (Selesai) 05 Feb    │
└─────────────────────────────────────┘
```

Klik kartu untuk lihat detail proyek yang sudah selesai.

---

## Buat Proyek Baru

**Route:** `/technician/requests/create`  
**View:** `technician/create.blade.php`

### Alur Pembuatan

#### Step 1: Informasi Proyek

**Form Input:**
```
┌─────────────────────────────────────┐
│ Buat Permintaan Barang Baru         │
├─────────────────────────────────────┤
│                                     │
│ Nama Proyek *                       │
│ [________________]                  │
│                                     │
│ Lokasi Proyek *                     │
│ [________________]                  │
│                                     │
│ Tanggal Mulai *                     │
│ [📅 Date Picker]                    │
│                                     │
│ Estimasi Durasi (hari) *            │
│ [__] hari                           │
│                                     │
│ Pilih Kit/Template (Optional)       │
│ [▼ Select Template...]              │
│                                     │
└─────────────────────────────────────┘
```

**Teknisi Name:** Auto-filled dengan nama user yang login

**Template/Kit:**
- Dropdown list semua template yang tersedia
- Jika pilih template, items akan auto-populated
- Bisa edit quantity setelah pilih template

#### Step 2: Pilih Barang

**Item Selection:**

**Button:** `+ Tambah Barang`

**Modal Popup:**
```
┌─────────────────────────────────────┐
│ Pilih Barang                     [X]│
├─────────────────────────────────────┤
│ [🔍 Search...]                      │
│                                     │
│ Kategori: Elektrikal                │
│ ☐ Kabel NYA 10m (KABEL-001)        │
│ ☐ MCB 10A (MCB-001)                 │
│                                     │
│ Kategori: Hand Tools                │
│ ☐ Tang Potong (TOOL-001)            │
│ ☐ Obeng Set (TOOL-002)              │
│                                     │
│ [Konfirmasi]                        │
└─────────────────────────────────────┘
```

**Selected Items Table:**
```
┌────────────────────────────────────────────────┐
│ Nama Barang    | Kode      | Qty | Stok | Unit │
├────────────────────────────────────────────────┤
│ Kabel NYA      | KABEL-001 | [5] | 100  | m    │
│ Tang Potong    | TOOL-001  | [2] | 10   | pcs  │
│ [🗑️ Hapus]                                     │
└────────────────────────────────────────────────┘
```

**Qty Input:**
- Bisa input quantity manual
- Validasi: tidak boleh melebihi stok tersedia
- Real-time stock check

#### Step 3: Review & Submit

**Summary:**
```
┌─────────────────────────────────────┐
│ Review Permintaan                   │
├─────────────────────────────────────┤
│ Proyek: Instalasi Gedung A          │
│ Lokasi: Jakarta Selatan             │
│ Tanggal: 11 Feb 2026                │
│ Durasi: 5 hari                      │
│                                     │
│ Items (3):                          │
│ • Kabel NYA - 5 m                   │
│ • Tang Potong - 2 pcs               │
│ • Obeng Set - 1 pcs                 │
│                                     │
│ [« Kembali]    [Submit Request »]   │
└─────────────────────────────────────┘
```

**Submit:**
- Create material request dengan status `PENDING`
- Redirect ke dashboard
- Notifikasi sukses

---

## Detail Proyek

**Route:** `/technician/projects/{id}`  
**View:** `technician/show.blade.php`

### Layout

**Header Info:**
```
┌─────────────────────────────────────┐
│ « Kembali                           │
│                                     │
│ 📋 Instalasi Gedung A               │
│ 🔵 Checked Out                      │
│                                     │
│ 📍 Jakarta Selatan                  │
│ 📅 11 Feb - 16 Feb 2026 (5 hari)    │
│ 👤 Teknisi 1                        │
└─────────────────────────────────────┘
```

**Status Badge** mengikuti status project:
- 🟡 Pending - Menunggu approval
- 🔵 Checked Out - Barang sudah keluar
- 🟣 Returned - Sudah check-in
- 🟢 Closed - Proyek selesai

**Daftar Barang:**

Dipisah berdasarkan tipe:

**Consumables (Barang Habis Pakai):**
```
┌─────────────────────────────────────┐
│ 📦 Consumables                      │
├─────────────────────────────────────┤
│ Kabel NYA 10m                       │
│ KABEL-001 • Qty: 5 m                │
│                                     │
│ Isolasi Listrik                     │
│ ISO-001 • Qty: 3 roll               │
└─────────────────────────────────────┘
```

**Tools (Alat/Peralatan):**
```
┌─────────────────────────────────────┐
│ 🔧 Tools                            │
├─────────────────────────────────────┤
│ Tang Potong                         │
│ TOOL-001 • Qty: 2 pcs               │
│                                     │
│ Obeng Set                           │
│ TOOL-002 • Qty: 1 set               │
└─────────────────────────────────────┘
```

**Action Buttons (sesuai status):**

**Jika Status = Checked Out:**
```
[✅ Check-in Barang]
```

**Jika Status = Pending:**
```
Menunggu approval admin...
```

**Jika Status = Returned/Closed:**
```
View only - tidak ada action
```

---

## Check-in Barang

**Route:** `/technician/projects/{id}/checkin`  
**View:** `technician/checkin.blade.php`

### Design Utama

**Background:** Hijau Mint (#f0fdf4) untuk kenyamanan mata

**Header:**
```
┌─────────────────────────────────────┐
│ « Kembali                           │
│                                     │
│ Check-in Selesai                    │
│ Instalasi Gedung A                  │
└─────────────────────────────────────┘
```

**Panduan Rekonsiliasi:**
```
┌─────────────────────────────────────┐
│ ℹ️ Panduan Rekonsiliasi:             │
│                                     │
│ Terpakai + Kembali + Rusak + Hilang │
│ = Qty Keluar                        │
└─────────────────────────────────────┘
```

### Form Check-in per Item

**Layout Horizontal:**
```
┌─────────────────────────────────────────────────────────────┐
│ Kabel NYA [🔍]        [5] Terpakai [0] Kembali [0] Rusak [0] Hilang │
│ KABEL-001 • 📦 Barang • Keluar: 10                          │
│                                                             │
│ [▼ Catatan & Foto]                                          │
│   Catatan: [Habis untuk instalasi panel...]                │
│   Foto: [📷 Upload]                                         │
└─────────────────────────────────────────────────────────────┘
```

**Komponen:**
1. **Nama Item** + QR Scanner Button 🔍
2. **Input Horizontal:**
   - **Terpakai** - jumlah yang dipakai/habis
   - **Kembali** - jumlah yang dikembalikan
   - **Rusak** - jumlah yang rusak
   - **Hilang** - jumlah yang hilang
3. **Info:** Kode, Tipe Badge, Qty Keluar
4. **Expandable:** Catatan & Upload Foto

### QR Scanner Feature

**Tombol Scanner** (🔍) di sebelah nama item:
- Klik untuk buka kamera/scanner
- Scan barcode item untuk validasi
- Auto-focus ke input field item yang discan
- Notifikasi jika barcode cocok

### Validasi Input

**Rules:**
```
Terpakai + Kembali + Rusak + Hilang = Qty Keluar
```

**Contoh:**
- Qty Keluar: 10 m
- Terpakai: 8 m
- Kembali: 2 m
- Rusak: 0 m
- Hilang: 0 m
- ✅ Total: 10 m (Valid!)

**Tools:**
- `Terpakai` selalu = 0 (karena tidak habis pakai)
- Must return semua atau mark sebagai rusak/hilang
- Contoh: 2 Tang keluar → 2 Kembali / 1 Kembali + 1 Rusak

### Optional Fields

**Per Item:**
- **Catatan (Notes)** - Textarea untuk penjelasan
- **Foto Bukti** - Upload gambar kondisi barang
  - Format: JPG, PNG
  - Max size: 5MB
  - Multiple photos allowed

### Submit Check-in

**Button:**
```
[✅ Submit Check-in]
```

**Proses:**
1. Validasi semua item
2. Update qty_used, qty_returned, qty_damaged, qty_lost
3. Set status → `RETURNED`
4. Redirect ke dashboard
5. Notifikasi: "Check-in selesai! Rekonsiliasi berhasil dicatat."

**Redirect:**
- Teknisi → `/technician/dashboard`
- Admin → `/requests/{id}` (jika admin yang check-in)

---

## Lihat Inventori Barang

**Route:** `/technician/items`  
**View:** `technician/items.blade.php`

### Tampilan Inventori

**Header:**
```
┌─────────────────────────────────────┐
│ « Kembali                           │
│                                     │
│ Inventori Barang                    │
│ Lihat stok barang tersedia          │
└─────────────────────────────────────┘
```

**Tabs:**
```
[🏷️ Semua] [📦 Consumables] [🔧 Tools]
```

**Search & Filter:**
```
[🔍 Search by nama atau kode...]

Kategori: [▼ Semua Kategori]
```

### Item Cards

**Consumables:**
```
┌─────────────────────────────────────┐
│ 📦 Kabel NYA 10m                    │
│ KABEL-001                           │
│                                     │
│ Kategori: Elektrikal                │
│ Stok: 95 m                          │
│ Unit: m                             │
└─────────────────────────────────────┘
```

**Tools:**
```
┌─────────────────────────────────────┐
│ 🔧 Tang Potong                      │
│ TOOL-001                            │
│                                     │
│ Kategori: Hand Tools                │
│ Tersedia: 8 pcs                     │
│ Unit: pcs                           │
└─────────────────────────────────────┘
```

**Badge Tipe:**
- 📦 **Consumables** - Orange badge
- 🔧 **Tools** - Blue badge

**Low Stock Indicator:**
```
⚠️ Stok Rendah
```

**Read Only:**
Teknisi hanya bisa **view**, tidak bisa edit/delete item.

---

## Navigasi & UI

### Layout

**No Sidebar** - Berbeda dari admin, teknisi tidak memiliki sidebar

**Header (Sticky):**
```
┌─────────────────────────────────────┐
│ 🏢 Pamtechno              👤 Profile│
└─────────────────────────────────────┘
```

**Footer Navigation (Mobile):**
```
┌─────────────────────────────────────┐
│ [🏠 Home] [📦 Items] [👤 Profile]   │
└─────────────────────────────────────┘
```

### Color Scheme

**Primary:** Green (#006600)
**Background:** Mint Green (#f0fdf4) untuk check-in
**Text:** Slate (800)
**Accents:**
- Pending: Yellow (#FCD34D)
- Checked Out: Blue (#3B82F6)
- Returned: Purple (#A855F7)
- Closed: Green (#10B981)

### Typography

- **Headers:** Bold, 2xl-lg
- **Body:** Regular, sm-base
- **Buttons:** Semibold, Rounded

### Mobile Optimization

- ✅ Touch-friendly buttons (min 44px)
- ✅ Keyboard numeric untuk qty input
- ✅ Swipe gestures untuk tabs
- ✅ Responsive grid layout
- ✅ Optimized images

---

## Alur Kerja Teknisi

### Workflow 1: Buat Project & Ambil Barang

```
1. Dashboard → Klik "Proyek Baru"
2. Isi form proyek (nama, lokasi, tanggal, durasi)
3. Pilih template (optional) atau tambah item manual
4. Review & Submit
5. Status: PENDING → menunggu admin approve
6. Admin approve & checkout
7. Status: CHECKED_OUT → barang siap diambil
8. Teknisi ambil barang dari gudang
9. Mulai kerja proyek
```

### Workflow 2: Selesai Proyek & Check-in

```
1. Proyek selesai → Kembali ke kantor
2. Dashboard → Klik proyek aktif
3. Klik "Check-in Barang"
4. Isi rekonsiliasi untuk setiap item:
   - Terpakai (consumables)
   - Kembali (tools)
   - Rusak/Hilang (jika ada)
5. Tambah catatan & foto (optional)
6. Submit Check-in
7. Status: RETURNED → menunggu admin close
8. Admin review → Close project
9. Status: CLOSED → muncul di Riwayat Selesai
```

### Workflow 3: Monitor Project

```
1. Dashboard → Lihat "Proyek Aktif"
2. Expand kartu untuk quick view items
3. Klik "Detail Lengkap" untuk full info
4. Track status project real-time
```

---

## Perbedaan dengan Admin View

| Fitur | Admin | Teknisi |
|-------|-------|---------|
| **Sidebar** | ✅ Ada | ❌ Tidak ada |
| **Dashboard Stats** | ✅ Full stats | ➖ Simplified |
| **Create Project** | ✅ Atas nama siapa saja | ✅ Atas nama sendiri |
| **Approve/Checkout** | ✅ Bisa | ❌ Tidak bisa |
| **Check-in** | ✅ Bisa semua project | ✅ Hanya project sendiri |
| **Edit Item** | ✅ Full CRUD | ❌ View only |
| **Laporan** | ✅ Akses penuh | ❌ Tidak ada akses |
| **Close Project** | ✅ Bisa | ❌ Tidak bisa |
| **Templates** | ✅ Create/Edit/Delete | ✅ View & Use only |

---

## Best Practices untuk Teknisi

### Sebelum Proyek:
1. ✅ Cek stok barang yang dibutuhkan
2. ✅ Gunakan template jika proyek berulang
3. ✅ Request barang beberapa hari sebelum mulai
4. ✅ Konfirmasi dengan admin jika urgent

### Selama Proyek:
1. ✅ Jaga barang dengan baik
2. ✅ Catat penggunaan barang
3. ✅ Foto kondisi barang jika ada kerusakan
4. ✅ Simpan tools di tempat aman

### Setelah Proyek:
1. ✅ Check-in sesegera mungkin
2. ✅ Isi rekonsiliasi dengan akurat
3. ✅ Upload foto bukti jika ada rusak/hilang
4. ✅ Berikan catatan detail jika diperlukan

---

## Troubleshooting

### Project tidak bisa dibuat?
- Cek koneksi internet
- Pastikan semua field required terisi
- Cek stok barang tersedia
- Contact admin jika masih error

### Check-in error?
- Validasi total qty = qty keluar
- Pastikan tidak ada field kosong
- Foto tidak terlalu besar (max 5MB)
- Refresh halaman dan coba lagi

### Barang tidak muncul?
- Cek filter & search
- Refresh halaman
- Contact admin untuk update stok

---

## Support

**Contact Admin:**
- Email: admin@pamtechno.com
- Phone: +62 XXX-XXXX-XXXX

**Version:** 1.0.0  
**Last Updated:** February 2026  
**Platform:** Web (Desktop & Mobile)
