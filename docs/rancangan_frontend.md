# Rancangan Implementasi Frontend - Pam-Inventory

Dokumen ini menjelaskan strategi implementasi antarmuka (UI/UX) untuk sistem Pam-Inventory, dengan fokus pada estetika "Premium", kemudahan penggunaan (Mobile Reporting), dan interaktivitas (Smart Template).

## 1. Stack Teknologi
*   **Template Engine**: Laravel Blade Components.
*   **CSS Framework**: Tailwind CSS (Latest).
*   **Interactivity**: Alpine.js (Ringan, cocok untuk dynamic forms tanpa build step complex seperti React/Vue full SPA).
*   **Icons**: Heroicons / Phosphor Icons.
*   **Font**: Inter / Poppins (Modern & Clean).

## 2. Design System & Estetika "Premium"
Untuk mencapai target "Wow Factor" dan "Premium":
*   **Glassmorphism**: Penggunaan latar belakang semi-transparan dengan blur pada kartu dan sidebar.
*   **Shadows**: Soft shadows (`shadow-lg`, `shadow-xl`) untuk kedalaman.
*   **Gradient**: Penggunaan gradien halus untuk header atau tombol aksi utama.
*   **Roundness**: `rounded-xl` atau `rounded-2xl` untuk elemen UI agar terlihat modern.
*   **Animations**: Transisi halus (`transition-all duration-300`) saat hover, modal open, atau page load.

### Layouts
1.  **Admin Layout (`layouts.app`)**:
    *   Sidebar Kiri (Collapsible): Navigasi utama.
    *   Top Bar: Profil, Notifikasi.
    *   Main Content: Area kerja.
2.  **Mobile Technician Layout (`layouts.mobile`)**:
    *   Fokus pada layar sempit.
    *   Bottom Navigation Bar (opsional) atau Simple Header.
    *   Card-based views untuk daftar proyek.

## 3. Detail Halaman (Page Breakdown)

### A. Admin Panel

#### 1. Dashboard
*   **Stats Cards**: Total Proyek Aktif, Low Stock Alert (Merah/Pulse), Laporan Menunggu Approval.
*   **Chart**: Grafik penggunaan barang per bulan (opsional).

#### 2. Master Data (Kategori & Barang)
*   **Tabel**: DataTables dengan styling modern (stripped rows, hover effect).
*   **Fitur**: Search bar real-time, Filter Kategori, Badges untuk stok (Hijau > Aman, Merah > Kritis).
*   **Modal**: Form tambah/edit barang muncul sebagai modal slide-over atau centered glass modal.

#### 3. Smart Template Editor (Fitur Kunci)
*   **Konsep**: Form dinamis "Repeater".
*   **UI**:
    *   Input Nama Template.
    *   Bagian "Daftar Barang":
        *   Baris 1: [Select Barang] [Input Qty] [Tombol Hapus (Icon Sampah)]
        *   Tombol [+ Tambah Barang] yang besar dan jelas.
*   **Teknis**: Menggunakan Alpine.js untuk menambah baris DOM tanpa reload halaman.

#### 4. Project Creation Wizard
*   **Step 1**: Info Dasar (Nama Proyek, Teknisi, Tipe).
*   **Step 2**: "Loading Template..." (Animasi).
*   **Step 3**: Review & Adjust Material.
    *   Sistem mempopulasi list barang dari template.
    *   Admin bisa mengubah Qty manual sebelum Finalize.

### B. Technician Mobile View

#### 1. Login Page
*   Desain bersih, logo Pam-Techno besar, input user/pass yang nyaman di jempol.

#### 2. "My Projects" List
*   **Tampilan Kartu**:
    *   Judul Proyek (Bold).
    *   Status Badge (Ongoing - Biru).
    *   Lokasi/Tanggal.
    *   Tombol "Lapor" (Primary Action).

#### 3. Reporting Form (The "Anti-Malas" Interface)
*   Form ini harus sangat mudah digunakan.
*   **Accordion / List Group**: Menampilkan barang satu per satu.
*   **Item Row**:
    *   Nama Barang (Jelas).
    *   Qty Bawa: 10 (Readonly, teks kecil).
    *   **Input Terpasang**: [ - ] 8 [ + ] (Stepper input biar mudah).
    *   **Input Rusak**: 0 -> Jika > 0, Slide down area "Upload Foto".
*   **Camera Integration**: Tombol "Ambil Foto" langsung memicu kamera HP (`<input type="file" capture="environment">`).

## 4. Alur Interaksi (User Flow)

### Scenario: Teknisi Lapor Barang Rusak
1.  Teknisi buka proyek "CCTV Gudang A".
2.  Scroll ke item "BNC Connector".
3.  Tekan tombol [+] pada field "Rusak" menjadi 1.
4.  UI otomatis menampilkan tombol merah "Upload Bukti".
5.  Teknisi klik, kamera terbuka, jepret foto.
6.  Thumbnail foto muncul.
7.  Teknisi klik "Kirim Laporan".
8.  Loader animasi muncul -> Sukses -> Redirect ke Dashboard.

## 5. Rencana File View (Laravel Blade)

```
resources/views/
├── layouts/
│   ├── app.blade.php      # Admin
│   ├── mobile.blade.php   # Teknisi
│   └── guest.blade.php    # Login
├── components/
│   ├── ui/                # Reusable UI (Button, Card, Modal)
│   ├── forms/             # Input, Select using Tailwind
├── admin/
│   ├── dashboard.blade.php
│   ├── items/             # CRUD Barang
│   ├── templates/         # Smart Editor
│   └── projects/          # Create Wizard
└── technician/
    ├── dashboard.blade.php
    └── reports/
        ├── create.blade.php  # Form Lapor
        └── show.blade.php    # History
```
