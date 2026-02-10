# Rancangan Sistem Pam-Inventory (Pamtechno)

Dokumen ini menjelaskan rancangan sistem, alur kerja (flow), use case, dan aktor yang terlibat dalam **Sistem Pengelolaan Barang Pamtechno**.

---

## 1. Aktor (Pengguna Sistem)

Sistem ini memiliki 2 aktor utama:

### 1. **Admin Gudang / Logistik**
- Bertanggung jawab atas stok fisik dan administrasi proyek
- **Tugas:**
  - Mengelola master data barang (CRUD items)
  - Membuat template/kit proyek
  - Approve dan checkout material requests
  - Verify check-in dan rekonsiliasi
  - Generate laporan (Loss & Damage, Stock Movement, Tool Utilization)
  - Close proyek setelah verifikasi

### 2. **Teknisi Lapangan**
- Pengguna yang membawa barang dan melakukan instalasi di lapangan
- **Tugas:**
  - Membuat material request (proyek baru)
  - Menerima barang yang sudah di-checkout
  - Melakukan instalasi/pekerjaan proyek
  - Check-in barang setelah proyek selesai
  - Input rekonsiliasi (terpakai, kembali, rusak, hilang)
  - Upload bukti foto jika ada kerusakan

---

## 2. Use Cases (Fitur Utama)

### A. Manajemen Master Data (Admin)

#### 1. Kelola Barang (Items)
- **CRUD Items**: Tambah, edit, hapus data barang
- **Attributes:**
  - Kode barang (unique)
  - Nama barang
  - Kategori
  - Tipe (Tools/Consumables)
  - Stok tersedia
  - Unit (pcs, m, box, roll, dll)
  - Harga per unit
- **Filter & Search**: By kategori, tipe, nama, atau kode

#### 2. Kelola Template/Kit Proyek
- **Create Template**: Membuat paket barang standar untuk jenis proyek tertentu
- **Contoh**: 
  - Template "Instalasi CCTV 4 Channel" berisi:
    - 4 Kamera CCTV
    - 1 DVR
    - 100m Kabel Coaxial
    - 8 Konektor BNC
    - 4 Jack DC
    - 1 Power Supply
- **Use Template**: Saat buat proyek baru, pilih template untuk auto-populate items

#### 3. Kelola Kategori
- Kategori untuk grouping items (misal: Elektrikal, Hand Tools, CCTV, Access Control)

### B. Manajemen Material Request / Barang Keluar (Admin & Teknisi)

#### 1. Create Material Request (Teknisi)
- Teknisi buat request baru dengan info:
  - Nama proyek
  - Lokasi proyek
  - Tanggal mulai
  - Estimasi durasi
  - Pilih template (optional)
  - Pilih items + quantity
- Status awal: **PENDING**

#### 2. Approve & Checkout (Admin)
- Admin review request
- Verify stok tersedia
- Approve & checkout barang
- Stok gudang berkurang
- Status berubah: **CHECKED_OUT**
- Teknisi bisa ambil barang

#### 3. Project Execution (Teknisi)
- Teknisi bawa barang ke lapangan
- Lakukan pekerjaan/instalasi
- Track status project

#### 4. Check-in & Rekonsiliasi (Teknisi)
- Setelah proyek selesai, check-in barang
- Input untuk setiap item:
  - **Terpakai**: Jumlah yang digunakan (untuk consumables)
  - **Kembali**: Jumlah yang dikembalikan (untuk tools)
  - **Rusak**: Jumlah yang rusak
  - **Hilang**: Jumlah yang hilang
- Validasi: Terpakai + Kembali + Rusak + Hilang = Qty Keluar
- Upload foto bukti (optional)
- Tambah catatan (optional)
- Status berubah: **RETURNED**

#### 5. Verify & Close (Admin)
- Admin review hasil check-in
- Verify rekonsiliasi
- Bisa edit jika ada kesalahan
- Close project
- Update stok:
  - Barang **Kembali** → Stok bertambah
  - Barang **Terpakai** → Tercatat sebagai used
  - Barang **Rusak/Hilang** → Tercatat di log, stok tidak bertambah
- Status berubah: **CLOSED**

### C. Reporting & Analytics (Admin)

#### 1. Dashboard
- Total barang
- Tools tersedia
- Proyek aktif
- Items low stock
- Tabs: Barang Keluar, Riwayat Proyek, Item Inventory

#### 2. Laporan Loss & Damage
- Filter: Tanggal, tipe, kategori
- Data: Proyek, teknisi, item, qty rusak, qty hilang, nilai kerugian
- Summary: Total rusak, total hilang, total nilai
- Export PDF

#### 3. Laporan Stock Movement
- Filter: Tanggal, kategori, tipe transaksi
- Data: Tanggal, item, transaksi type, qty, stok before/after, reference
- Summary: Total in, total out, current stock
- Export PDF

#### 4. Laporan Tool Utilization
- Filter: Tanggal, kategori
- Data: Tool, frequency, days out, utilization rate
- Metrics: Usage count, avg days per project
- Export PDF

---

## 3. Alur Kerja Sistem (System Flow)

### Flow 1: Persiapan Proyek (Create & Checkout)

```
[TEKNISI]
1. Login ke sistem
2. Dashboard → Klik "Proyek Baru"
3. Isi form proyek (nama, lokasi, tanggal, durasi)
4. Pilih template (optional) atau tambah item manual
5. Submit request
6. Status: PENDING

[ADMIN]
7. Receive notification → Review request
8. Check stok tersedia
9. Approve request
10. Click "Checkout"
11. Sistem kurangi stok gudang
12. Status: CHECKED_OUT
13. Notify teknisi

[TEKNISI]
14. Ambil barang dari gudang
15. Bawa ke lokasi proyek
16. Mulai pekerjaan
```

### Flow 2: Eksekusi & Check-in Proyek

```
[TEKNISI - Di Lapangan]
1. Lakukan instalasi/pekerjaan
2. Gunakan barang sesuai kebutuhan
3. Catat penggunaan barang
4. Foto barang rusak (jika ada)

[TEKNISI - Setelah Selesai]
5. Kembali ke kantor dengan barang sisa
6. Login ke sistem
7. Dashboard → Pilih proyek aktif
8. Klik "Check-in Barang"
9. Isi rekonsiliasi per item:
   - Consumables: Input terpakai, rusak, hilang
   - Tools: Input kembali, rusak, hilang
10. Upload foto bukti (jika ada rusak/hilang)
11. Tambah catatan
12. Submit check-in
13. Status: RETURNED

[ADMIN]
14. Receive notification
15. Review rekonsiliasi
16. Verify data accuracy
17. Check foto bukti
18. Edit jika perlu (via Edit Reconciliation)
19. Click "Close Project"
20. Sistem update stok berdasarkan reconciliation
21. Status: CLOSED
22. Generate project report
```

### Flow 3: Monitoring & Reporting

```
[ADMIN]
1. Dashboard → View statistik real-time
2. Monitor proyek aktif
3. Check items dengan stok rendah
4. Reports:
   - Generate Loss & Damage report
   - Export Stock Movement report
   - Analyze Tool Utilization
5. Export PDF untuk dokumentasi
6. Ambil keputusan restock/procurement
```

---

## 4. Status Lifecycle

### Material Request Status:
```
PENDING → CHECKED_OUT → RETURNED → CLOSED
         ↓
      CANCELED (optional)
```

**Status Details:**
- **PENDING**: Request dibuat, menunggu approval admin
- **CHECKED_OUT**: Approved & barang sudah keluar dari gudang
- **RETURNED**: Barang sudah di-check-in, menunggu admin close
- **CLOSED**: Proyek selesai, rekonsiliasi verified
- **CANCELED**: Request dibatalkan (optional feature)

---

## 5. Perbedaan Admin vs Teknisi

| Feature | Admin | Teknisi |
|---------|-------|---------|
| **View** | Sidebar navigation | No sidebar, mobile-first |
| **Dashboard** | Full stats + 3 tabs | Simplified, proyek aktif + riwayat |
| **Create Project** | Bisa atas nama siapa saja | Hanya atas nama sendiri |
| **Approve Request** | ✅ Bisa | ❌ Tidak bisa |
| **Checkout** | ✅ Bisa | ❌ Tidak bisa |
| **Check-in** | ✅ Semua project | ✅ Project sendiri saja |
| **Edit Reconciliation** | ✅ Bisa | ❌ Tidak bisa |
| **Close Project** | ✅ Bisa | ❌ Tidak bisa |
| **Manage Items** | ✅ CRUD | ❌ View only |
| **Manage Templates** | ✅ CRUD | ✅ Use only |
| **Reports** | ✅ Full access | ❌ No access |
| **Background Color** | White | Mint green untuk check-in |

---

## 6. Fitur Khusus

### 1. QR/Barcode Scanner
- Tombol scanner di halaman check-in
- Scan barcode item untuk quick find
- Auto-focus ke input field item yang discan

### 2. Photo Evidence
- Upload foto untuk barang rusak/hilang
- Multiple photos per item
- Display di reconciliation view

### 3. Smart Template
- Pre-defined item combinations
- Auto-populate saat create project
- Editable quantity

### 4. Real-time Stock Tracking
- Update stok langsung saat checkout/check-in
- Low stock alerts
- Stock movement history

### 5. Mobile-Optimized (Teknisi)
- Responsive design
- Touch-friendly UI
- Keyboard optimization untuk input
- Background hijau mint untuk kenyamanan

---

## 7. Teknologi Yang Digunakan

### Backend
- **Framework**: Laravel 12 (PHP 8.2)
- **Database**: MySQL/MariaDB
- **ORM**: Eloquent
- **Authentication**: Laravel Breeze

### Frontend
- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS
- **JavaScript**: Alpine.js
- **Asset Bundling**: Vite
- **Icons**: Heroicons (SVG)

### Infrastructure
- **Docker**: Containerization
- **Web Server**: Nginx/Apache
- **PHP-FPM**: Process manager

### Key Libraries
- **PDF Generation**: DomPDF (untuk export laporan)
- **Barcode**: Tergantung implementasi scanner

---

## 8. Security & Validation

### Authentication
- Role-based access control (Admin/Technician)
- Session management
- Remember me functionality

### Authorization
- Middleware untuk protect routes
- Role checking di controller
- View-level permission

### Validation
- Server-side validation semua input
- Stock availability check saat checkout
- Reconciliation total validation
- File upload validation (type, size)

### Data Protection
- CSRF protection
- SQL injection prevention (via Eloquent)
- XSS prevention (via Blade escaping)
- Secure file uploads

---

## 9. Future Enhancements (Optional)

1. **Notifications**
   - Email/SMS untuk approval request
   - Push notification untuk mobile
   - Low stock alerts

2. **Advanced Reporting**
   - Dashboard charts/graphs
   - Trend analysis
   - Predictive analytics

3. **Mobile App**
   - Native Android/iOS app
   - Offline mode
   - Better barcode scanning

4. **Approval Workflow**
   - Multi-level approval
   - Supervisor role
   - Delegation

5. **Integration**
   - Export ke accounting software
   - API untuk third-party integration
   - Warehouse management system

---

## Support & Documentation

- **Admin Guide**: `docs/admin-view-guide.md`
- **Technician Guide**: `docs/technician-view-guide.md`
- **Database Schema**: `docs/rancangan_database.md`
- **Developer**: Pamtechno Team
- **Version**: 1.0.0
- **Last Updated**: February 2026
