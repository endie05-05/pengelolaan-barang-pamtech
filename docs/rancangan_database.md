# Rancangan Database Pam-Inventory

Dokumen ini menjelaskan struktur database (Schema) untuk sistem Pam-Inventory.

## Entity Relationship Diagram (ERD) Overview

Sistem ini terdiri dari entitas utama:
*   **Master Data**: `users`, `items`, `project_templates`
*   **Transaksi**: `projects`, `project_materials`, `field_reports`

## Detail Tabel

### 1. `users` (Tabel Pengguna)
*Bawaan Laravel, dengan penyesuaian.*
*   `id` (BigInt, PK)
*   `name` (String)
*   `email` (String, Unique)
*   `password` (String)
*   `role` (String/Enum): 'admin', 'technician', 'supervisor'
*   `created_at`, `updated_at`

### 2. `categories` (Kategori Barang)
*   `id` (BigInt, PK)
*   `name` (String): Nama kategori (misal: "CCTV", "Access Control")
*   `description` (Text, Nullable)
*   `created_at`, `updated_at`

### 3. `items` (Master Barang)
*   `id` (BigInt, PK)
*   `category_id` (BigInt, FK -> categories): Kategori barang
*   `code` (String, Unique): Kode barang / SKU (misal: "CBL-001")
*   `barcode` (String, Nullable, Unique): Barcode/QR Code scanner value
*   `name` (String): Nama barang (misal: "Kabel Coaxial RG59")
*   `unit` (String): Satuan (misal: "Meter", "Pcs", "Roll")
*   `stock` (Integer): Stok saat ini di gudang utama
*   `min_stock` (Integer, Default 0): Batas minimum untuk Alert Restock
*   `created_at`, `updated_at`

### 4. `project_templates` (Template Proyek)
*   `id` (BigInt, PK)
*   `name` (String): Nama template (misal: "Pasang CCTV 4 Channel")
*   `description` (Text, Nullable)
*   `created_at`, `updated_at`

### 5. `template_items` (Item dalam Template)
*   `id` (BigInt, PK)
*   `project_template_id` (BigInt, FK -> project_templates)
*   `item_id` (BigInt, FK -> items)
*   `default_qty` (Integer): Jumlah standar yang disarankan
*   `created_at`, `updated_at`

### 6. `projects` (Data Proyek)
*   `id` (BigInt, PK)
*   `name` (String): Nama proyek (misal: "Instalasi CCTV Gudang B")
*   `technician_id` (BigInt, FK -> users): Teknisi penanggung jawab
*   `admin_id` (BigInt, FK -> users): Admin yang membuat proyek
*   `status` (String/Enum): 'preparation', 'active', 'completed', 'canceled'
*   `start_date` (Date)
*   `end_date` (Date, Nullable)
*   `created_at`, `updated_at`

### 7. `project_materials` (Barang Per Proyek / Stok Keluar)
*Barang yang dibawa teknisi dari gudang untuk proyek tertentu.*
*   `id` (BigInt, PK)
*   `project_id` (BigInt, FK -> projects)
*   `item_id` (BigInt, FK -> items)
*   `qty_taken` (Integer): Jumlah awal yang dibawa
*   `created_at`, `updated_at`

### 8. `field_reports` (Laporan Lapangan)
*   `id` (BigInt, PK)
*   `project_id` (BigInt, FK -> projects)
*   `technician_id` (BigInt, FK -> users)
*   `reported_at` (Datetime): Waktu pelaporan
*   `notes` (Text, Nullable): Catatan tambahan
*   `status` (String/Enum): 'draft', 'submitted', 'approved', 'rejected'
*   `created_at`, `updated_at`

### 9. `field_report_items` (Detail Laporan Barang)
*   `id` (BigInt, PK)
*   `field_report_id` (BigInt, FK -> field_reports)
*   `project_material_id` (BigInt, FK -> project_materials): Referensi ke barang yang dibawa
*   `qty_installed` (Integer): Jumlah terpasang (Good)
*   `qty_damaged` (Integer): Jumlah rusak (Defect)
*   `qty_leftover` (Integer): Jumlah sisa (dikembalikan ke gudang)
*   `created_at`, `updated_at`

### 10. `evidence_photos` (Bukti Foto)
*   `id` (BigInt, PK)
*   `field_report_item_id` (BigInt, FK -> field_report_items)
*   `photo_path` (String): Lokasi file foto
*   `description` (String, Nullable)
*   `created_at`, `updated_at`

### 11. `damaged_items_log` (Log Barang Rusak)
*   `id` (BigInt, PK)
*   `item_id` (BigInt, FK -> items)
*   `field_report_item_id` (BigInt, FK -> field_report_items): Asal laporan kerusakan
*   `qty` (Integer): Jumlah rusak
*   `notes` (Text, Nullable): Keterangan admin/tindakan (misal: "Scrapped", "Sent to Service")
*   `created_at`, `updated_at`

## Relasi Penting & Logika Bisnis
1.  **Smart Template Flow**: Saat Admin memilih `Project Template`, sistem menyalin data dari `template_items` ke UI pembuatan proyek. Saat disimpan, data masuk ke `project_materials`.
2.  **Reporting Flow (Multiple Logic)**: 
    *   Teknisi dapat mengirim **beberapa laporan** untuk satu proyek (misal hari 1, hari 2).
    *   **Validasi**: Total (`qty_installed` + `qty_damaged` + `qty_leftover`) dari SELURUH laporan per-item TIDAK BOLEH melebihi `project_materials.qty_taken`.
3.  **Stock Mutation**:
    *   Saat `project_materials` dibuat -> Stok `items` (Gudang) **Berkurang**.
    *   Saat `field_report` diapprove ->
        *   `qty_leftover` -> Stok `items` (Gudang) **Bertambah**.
        *   `qty_damaged` -> Stok `items` (Gudang) **TIDAK Bertambah**, tapi dicatat ke `damaged_items_log`.
    *   **Alert**: Setiap perubahan stok, cek `if (stock <= min_stock)`.
