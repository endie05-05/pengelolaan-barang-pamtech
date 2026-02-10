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
            'password' => bcrypt('andicedek'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Teknisi 1',
            'email' => 'teknisi@pamtech.com',
            'password' => bcrypt('password'),
            'role' => 'technician',
        ]);

        // Categories
        $catCCTV = Category::create(['name' => 'Hardware CCTV', 'description' => 'Perangkat keras CCTV']);
        $catCabling = Category::create(['name' => 'Cabling', 'description' => 'Kabel dan connector']);
        $catAccess = Category::create(['name' => 'Access Control', 'description' => 'Perangkat akses kontrol']);
        $catTools = Category::create(['name' => 'Tools', 'description' => 'Alat kerja']);

        // Items - Equipment (dipasang di klien)
        $camDome = Item::create([
            'name' => 'CCTV Camera Dome 2MP',
            'category_id' => $catCCTV->id,
            'code' => 'CAM-DOME-001',
            'barcode' => 'CAM-DOME-001',
            'unit' => 'pcs',
            'stock' => 50,
            'min_stock' => 10,
            'item_type' => 'equipment',
        ]);

        $camBullet = Item::create([
            'name' => 'CCTV Camera Bullet 2MP',
            'category_id' => $catCCTV->id,
            'code' => 'CAM-BULLET-001',
            'barcode' => 'CAM-BULLET-001',
            'unit' => 'pcs',
            'stock' => 40,
            'min_stock' => 10,
            'item_type' => 'equipment',
        ]);

        // Items - Materials (consumable)
        $cableRG59 = Item::create([
            'name' => 'Kabel RG59 + Power',
            'category_id' => $catCabling->id,
            'code' => 'CABLE-RG59-001',
            'barcode' => 'CABLE-RG59-001',
            'unit' => 'meter',
            'stock' => 1000,
            'min_stock' => 200,
            'item_type' => 'materials',
        ]);

        $bncConnector = Item::create([
            'name' => 'BNC Connector',
            'category_id' => $catCabling->id,
            'code' => 'BNC-001',
            'barcode' => 'BNC-001',
            'unit' => 'pcs',
            'stock' => 200,
            'min_stock' => 50,
            'item_type' => 'materials',
        ]);

        $dvr8ch = Item::create([
            'name' => 'DVR 8 Channel',
            'category_id' => $catCCTV->id,
            'code' => 'DVR-8CH-001',
            'barcode' => 'DVR-8CH-001',
            'unit' => 'pcs',
            'stock' => 15,
            'min_stock' => 3,
            'item_type' => 'equipment',
        ]);

        $psu = Item::create([
            'name' => 'Power Supply 12V 5A',
            'category_id' => $catCCTV->id,
            'code' => 'PSU-12V-001',
            'barcode' => 'PSU-12V-001',
            'unit' => 'pcs',
            'stock' => 30,
            'min_stock' => 10,
            'item_type' => 'materials',
        ]);

        $hdd = Item::create([
            'name' => 'HDD 1TB Surveillance',
            'category_id' => $catCCTV->id,
            'code' => 'HDD-1TB-001',
            'barcode' => 'HDD-1TB-001',
            'unit' => 'pcs',
            'stock' => 20,
            'min_stock' => 5,
            'item_type' => 'equipment',
        ]);

        $fingerprint = Item::create([
            'name' => 'Fingerprint Reader',
            'category_id' => $catAccess->id,
            'code' => 'FP-001',
            'barcode' => 'FP-001',
            'unit' => 'pcs',
            'stock' => 25,
            'min_stock' => 5,
            'item_type' => 'equipment',
        ]);

        $rfidReader = Item::create([
            'name' => 'RFID Card Reader',
            'category_id' => $catAccess->id,
            'code' => 'RFID-001',
            'barcode' => 'RFID-001',
            'unit' => 'pcs',
            'stock' => 30,
            'min_stock' => 8,
            'item_type' => 'equipment',
        ]);

        $doorLock = Item::create([
            'name' => 'Electric Door Lock',
            'category_id' => $catAccess->id,
            'code' => 'LOCK-001',
            'barcode' => 'LOCK-001',
            'unit' => 'pcs',
            'stock' => 20,
            'min_stock' => 5,
            'item_type' => 'equipment',
        ]);

        // Items - Tools (dipinjam, dikembalikan)
        $drill = Item::create([
            'name' => 'Mesin Bor',
            'category_id' => $catTools->id,
            'code' => 'TOOL-DRILL-001',
            'barcode' => 'TOOL-DRILL-001',
            'unit' => 'pcs',
            'stock' => 5,
            'min_stock' => 2,
            'item_type' => 'tools',
        ]);

        $tangga = Item::create([
            'name' => 'Tangga Lipat 2M',
            'category_id' => $catTools->id,
            'code' => 'TOOL-LADDER-001',
            'barcode' => 'TOOL-LADDER-001',
            'unit' => 'pcs',
            'stock' => 3,
            'min_stock' => 1,
            'item_type' => 'tools',
        ]);

        $toolkit = Item::create([
            'name' => 'Toolkit Set',
            'category_id' => $catTools->id,
            'code' => 'TOOL-KIT-001',
            'barcode' => 'TOOL-KIT-001',
            'unit' => 'set',
            'stock' => 5,
            'min_stock' => 2,
            'item_type' => 'tools',
        ]);

        // Templates
        $cctv4ch = ProjectTemplate::create([
            'name' => 'Paket CCTV 4 Channel',
            'description' => 'Instalasi CCTV standar 4 kamera',
        ]);
        TemplateItem::create(['project_template_id' => $cctv4ch->id, 'item_id' => $camDome->id, 'default_qty' => 4]);
        TemplateItem::create(['project_template_id' => $cctv4ch->id, 'item_id' => $cableRG59->id, 'default_qty' => 100]);
        TemplateItem::create(['project_template_id' => $cctv4ch->id, 'item_id' => $bncConnector->id, 'default_qty' => 20]);
        TemplateItem::create(['project_template_id' => $cctv4ch->id, 'item_id' => $dvr8ch->id, 'default_qty' => 1]);
        TemplateItem::create(['project_template_id' => $cctv4ch->id, 'item_id' => $psu->id, 'default_qty' => 5]);
        TemplateItem::create(['project_template_id' => $cctv4ch->id, 'item_id' => $hdd->id, 'default_qty' => 1]);
        TemplateItem::create(['project_template_id' => $cctv4ch->id, 'item_id' => $drill->id, 'default_qty' => 1]); // Tool
        TemplateItem::create(['project_template_id' => $cctv4ch->id, 'item_id' => $tangga->id, 'default_qty' => 1]); // Tool

        $cctv8ch = ProjectTemplate::create([
            'name' => 'Paket CCTV 8 Channel',
            'description' => 'Instalasi CCTV premium 8 kamera',
        ]);
        TemplateItem::create(['project_template_id' => $cctv8ch->id, 'item_id' => $camDome->id, 'default_qty' => 4]);
        TemplateItem::create(['project_template_id' => $cctv8ch->id, 'item_id' => $camBullet->id, 'default_qty' => 4]);
        TemplateItem::create(['project_template_id' => $cctv8ch->id, 'item_id' => $cableRG59->id, 'default_qty' => 200]);
        TemplateItem::create(['project_template_id' => $cctv8ch->id, 'item_id' => $bncConnector->id, 'default_qty' => 40]);
        TemplateItem::create(['project_template_id' => $cctv8ch->id, 'item_id' => $dvr8ch->id, 'default_qty' => 1]);
        TemplateItem::create(['project_template_id' => $cctv8ch->id, 'item_id' => $psu->id, 'default_qty' => 10]);
        TemplateItem::create(['project_template_id' => $cctv8ch->id, 'item_id' => $hdd->id, 'default_qty' => 1]);
        TemplateItem::create(['project_template_id' => $cctv8ch->id, 'item_id' => $drill->id, 'default_qty' => 1]); // Tool
        TemplateItem::create(['project_template_id' => $cctv8ch->id, 'item_id' => $tangga->id, 'default_qty' => 1]); // Tool
        TemplateItem::create(['project_template_id' => $cctv8ch->id, 'item_id' => $toolkit->id, 'default_qty' => 1]); // Tool

        $accessControl = ProjectTemplate::create([
            'name' => 'Paket Access Control Fingerprint',
            'description' => 'Instalasi access control dengan fingerprint',
        ]);
        TemplateItem::create(['project_template_id' => $accessControl->id, 'item_id' => $fingerprint->id, 'default_qty' => 2]);
        TemplateItem::create(['project_template_id' => $accessControl->id, 'item_id' => $doorLock->id, 'default_qty' => 2]);
        TemplateItem::create(['project_template_id' => $accessControl->id, 'item_id' => $cableRG59->id, 'default_qty' => 50]);
        TemplateItem::create(['project_template_id' => $accessControl->id, 'item_id' => $psu->id, 'default_qty' => 3]);
        TemplateItem::create(['project_template_id' => $accessControl->id, 'item_id' => $drill->id, 'default_qty' => 1]); // Tool
    }
}
