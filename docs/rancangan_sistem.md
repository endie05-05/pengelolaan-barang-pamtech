# Rancangan Sistem Pam-Inventory (Pam-Techno)

Dokumen ini menjelaskan rancangan detail, alur kerja (flow), use case, dan aktor yang terlibat dalam sistem Pam-Inventory.

## 1. Aktor (Pengguna Sistem)

Sistem ini memiliki 3 aktor utama:

1.  **Admin Gudang / Logistik**
    *   Bertanggung jawab atas stok fisik dan administrasi proyek.
    *   Tugas: Mengelola data barang, membuat template proyek, membuat proyek baru, dan memvalidasi laporan teknisi.
2.  **Teknisi Lapangan**
    *   Pengguna yang membawa barang dan melakukan instalasi di lapangan.
    *   Tugas: Menerima barang, melakukan instalasi, dan melaporkan pemakaian barang (Mobile Reporting).
3.  **Supervisor / Manajer** (Opsional untuk fase 1)
    *   Memantau performa proyek dan efisiensi penggunaan barang.

## 2. Use Cases (Fitur Utama)

### A. Manajemen Master Data (Admin)
*   **Kelola Barang**: Tambah, ubah, hapus data barang (Kabel, CCTV, BNC, dll).
*   **Kelola Template (Smart Template)**: Membuat paket barang standar.
    *   *Contoh*: Template "Pasang CCTV 4 Channel" otomatis berisi: 4 Kamera, 1 DVR, 100m Kabel, 8 BNC, 4 Jack DC.

### B. Manajemen Proyek & Stok Keluar (Admin)
*   **Buat Proyek Baru**: Memilih tipe proyek dan teknisi penanggung jawab.
*   **Assignment Barang (Barang Keluar)**:
    *   Sistem memuat daftar barang dari *Smart Template*.
    *   Admin menyesuaikan jumlah aktual yang dibawa teknisi.
    *   Stok Gudang berkurang, Stok Proyek (di tangan teknisi) bertambah.

### C. Pelaporan Lapangan / Mobile Reporting (Teknisi)
*   **Lihat Proyek Aktif**: Melihat daftar proyek yang sedang ditangani.
*   **Input Laporan**:
    *   Input jumlah **Terpasang** (Good).
    *   Input jumlah **Rusak** (Defect).
    *   Input jumlah **Sisa** (Leftover).
*   **Upload Bukti Foto**: Jika ada barang rusak, sistem mewajibkan upload foto.

### D. Rekonsiliasi & Pengembalian (Admin)
*   **Verifikasi Laporan**: Admin mengecek laporan teknisi.
*   **Restock Sisa**: Barang status "Sisa" dikembalikan ke stok gudang utama.

## 3. Alur Kerja Sistem (System Flow)

### Flow 1: Persiapan Proyek (Barang Keluar)
1.  **Admin** login ke dashboard web.
2.  **Admin** membuat Proyek baru (misal: "Instalasi CCTV PT. ABC").
3.  **Admin** memilih **Tipe Proyek** -> "Instalasi CCTV".
4.  **Sistem** otomatis menampilkan daftar barang berdasarkan **Smart Template** (Kamera, Kabel, dll).
5.  **Admin** mengonfirmasi atau mengedit jumlah barang yang dibawa teknisi.
6.  **Admin** klik "Simpan/Assign".
7.  **Sistem** mengurangi stok gudang dan mencatat perpindahan barang ke teknisi.

### Flow 2: Pelaporan di Lapangan (Mobile)
1.  **Teknisi** login melalui browser HP.
2.  **Teknisi** memilih menu "Proyek Saya" dan klik proyek yang sedang dikerjakan.
3.  **Sistem** menampilkan daftar barang yang dibawa (dari Flow 1).
4.  **Teknisi** mengisi form untuk setiap barang:
    *   *Contoh*: Bawa 10 BNC.
    *   Terpasang: 8.
    *   Rusak: 1 (Wajib Foto).
    *   Sisa: 1.
5.  **Teknisi** mengambil foto konektor yang rusak dan menguploadnya.
6.  **Teknisi** klik "Kirim Laporan".
7.  **Sistem** menyimpan data dan mengubah status proyek menjadi "Menunggu Verifikasi".

### Flow 3: Verifikasi & Selesai
1.  **Admin** menerima notifikasi laporan masuk.
2.  **Admin** memeriksa kesesuaian data (Barang Bawa = Pasang + Rusak + Sisa).
3.  **Admin** memeriksa foto bukti kerusakan.
4.  **Admin** menyetujui laporan ("Approve").
    *   Barang **Terpasang**: Dicatat sebagai *Sold* / *Used*.
    *   Barang **Rusak**: Dicatat sebagai *Write-off* / *Scrap*.
    *   Barang **Sisa**: Otomatis kembali menambah stok gudang (atau status "Barang Kembali" menunggu fisik diterima).

## 4. Teknologi Yang Digunakan
*   **Backend**: Laravel (PHP).
*   **Database**: MySQL/MariaDB.
*   **Frontend**: Blade Templates (Responsive dengan CSS Framework Tailwind).
*   **Fokus UI**: Mobile-First untuk halaman Teknisi.
