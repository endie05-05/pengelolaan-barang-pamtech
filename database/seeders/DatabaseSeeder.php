<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\ProjectTemplate;
use App\Models\TemplateItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::create([
            'name' => 'Admin Pamtech',
            'email' => 'admin@pamtech.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Teknisi 1',
            'email' => 'teknisi@pamtech.com',
            'password' => bcrypt('password'),
            'role' => 'technician',
        ]);

        // Categories
        Category::create(['name' => 'Hardware CCTV', 'description' => 'Perangkat keras CCTV']);
        Category::create(['name' => 'Cabling', 'description' => 'Kabel dan connector']);
        Category::create(['name' => 'Access Control', 'description' => 'Perangkat akses kontrol']);
        Category::create(['name' => 'Tools', 'description' => 'Alat kerja']);

        // Items
        Item::create(['name' => 'CCTV Camera Dome 2MP', 'category_id' => 1, 'barcode' => 'CAM-DOME-001', 'unit' => 'pcs', 'current_stock' => 50, 'minimum_stock' => 10, 'description' => 'Camera dome indoor 2 megapixel']);
        Item::create(['name' => 'CCTV Camera Bullet 2MP', 'category_id' => 1, 'barcode' => 'CAM-BULLET-001', 'unit' => 'pcs', 'current_stock' => 40, 'minimum_stock' => 10, 'description' => 'Camera bullet outdoor 2 megapixel']);
        Item::create(['name' => 'Kabel RG59 + Power', 'category_id' => 2, 'barcode' => 'CABLE-RG59-001', 'unit' => 'meter', 'current_stock' => 1000, 'minimum_stock' => 200, 'description' => 'Kabel coaxial RG59 dengan power']);
        Item::create(['name' => 'BNC Connector', 'category_id' => 2, 'barcode' => 'BNC-001', 'unit' => 'pcs', 'current_stock' => 200, 'minimum_stock' => 50, 'description' => 'BNC male connector']);
        Item::create(['name' => 'DVR 8 Channel', 'category_id' => 1, 'barcode' => 'DVR-8CH-001', 'unit' => 'pcs', 'current_stock' => 15, 'minimum_stock' => 3, 'description' => 'Digital Video Recorder 8 channel']);
        Item::create(['name' => 'Power Supply 12V 5A', 'category_id' => 1, 'barcode' => 'PSU-12V-001', 'unit' => 'pcs', 'current_stock' => 30, 'minimum_stock' => 10, 'description' => 'Adaptor 12V 5A untuk CCTV']);
        Item::create(['name' => 'HDD 1TB Surveillance', 'category_id' => 1, 'barcode' => 'HDD-1TB-001', 'unit' => 'pcs', 'current_stock' => 20, 'minimum_stock' => 5, 'description' => 'Hard disk khusus CCTV 1TB']);
        Item::create(['name' => 'Fingerprint Reader', 'category_id' => 3, 'barcode' => 'FP-001', 'unit' => 'pcs', 'current_stock' => 25, 'minimum_stock' => 5, 'description' => 'Fingerprint scanner untuk access control']);
        Item::create(['name' => 'RFID Card Reader', 'category_id' => 3, 'barcode' => 'RFID-001', 'unit' => 'pcs', 'current_stock' => 30, 'minimum_stock' => 8, 'description' => 'RFID card reader 125KHz']);
        Item::create(['name' => 'Electric Door Lock', 'category_id' => 3, 'barcode' => 'LOCK-001', 'unit' => 'pcs', 'current_stock' => 20, 'minimum_stock' => 5, 'description' => 'Magnetic door lock 280kg']);

        // Templates
        $cctv4ch = ProjectTemplate::create(['name' => 'Paket CCTV 4 Channel', 'description' => 'Instalas CCTV standar 4 kamera', 'type' => 'cctv']);
        TemplateItem::create(['template_id' => $cctv4ch->id, 'item_id' => 1, 'default_quantity' => 4]);
        TemplateItem::create(['template_id' => $cctv4ch->id, 'item_id' => 3, 'default_quantity' => 100]);
        TemplateItem::create(['template_id' => $cctv4ch->id, 'item_id' => 4, 'default_quantity' => 20]);
        TemplateItem::create(['template_id' => $cctv4ch->id, 'item_id' => 5, 'default_quantity' => 1]);
        TemplateItem::create(['template_id' => $cctv4ch->id, 'item_id' => 6, 'default_quantity' => 5]);
        TemplateItem::create(['template_id' => $cctv4ch->id, 'item_id' => 7, 'default_quantity' => 1]);

        $cctv8ch = ProjectTemplate::create(['name' => 'Paket CCTV 8 Channel', 'description' => 'Instalasi CCTV premium 8 kamera', 'type' => 'cctv']);
        TemplateItem::create(['template_id' => $cctv8ch->id, 'item_id' => 1, 'default_quantity' => 4]);
        TemplateItem::create(['template_id' => $cctv8ch->id, 'item_id' => 2, 'default_quantity' => 4]);
        TemplateItem::create(['template_id' => $cctv8ch->id, 'item_id' => 3, 'default_quantity' => 200]);
        TemplateItem::create(['template_id' => $cctv8ch->id, 'item_id' => 4, 'default_quantity' => 40]);
        TemplateItem::create(['template_id' => $cctv8ch->id, 'item_id' => 5, 'default_quantity' => 1]);
        TemplateItem::create(['template_id' => $cctv8ch->id, 'item_id' => 6, 'default_quantity' => 10]);
        TemplateItem::create(['template_id' => $cctv8ch->id, 'item_id' => 7, 'default_quantity' => 1]);

        $accessControl = ProjectTemplate::create(['name' => 'Paket Access Control Fingerprint', 'description' => 'Instalasi access control dengan fingerprint', 'type' => 'access_control']);
        TemplateItem::create(['template_id' => $accessControl->id, 'item_id' => 8, 'default_quantity' => 2]);
        TemplateItem::create(['template_id' => $accessControl->id, 'item_id' => 10, 'default_quantity' => 2]);
        TemplateItem::create(['template_id' => $accessControl->id, 'item_id' => 3, 'default_quantity' => 50]);
        TemplateItem::create(['template_id' => $accessControl->id, 'item_id' => 6, 'default_quantity' => 3]);
    }
}
