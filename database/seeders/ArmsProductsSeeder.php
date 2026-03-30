<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ArmsProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Rifles (Category ID: 2)
            [
                'name' => 'M16A4',
                'description' => 'Semi-automatic tactical rifle with rail system. Features modular design, picatinny rails, and precision engineering. Caliber: 5.56 NATO. Effective range: 500+ meters. Perfect for tactical operations.',
                'price' => 55000,
                'stock_quantity' => 15,
                'image_path' => null,
                'category_id' => 2,
            ],
            [
                'name' => 'M4 Carbine',
                'description' => 'Compact assault rifle platform with short barrel for CQB operations. Caliber: 5.56 NATO. Length: 33.5 inches. Comes with Picatinny rails for customization. Excellent for tactical teams.',
                'price' => 52500,
                'stock_quantity' => 18,
                'image_path' => null,
                'category_id' => 2,
            ],
            [
                'name' => 'L85A2',
                'description' => 'British bullpup rifle design with integrated carrying handle. Caliber: 5.56 NATO. Compact design for vehicle operations. Advanced ergonomics and reliability in harsh conditions.',
                'price' => 58000,
                'stock_quantity' => 12,
                'image_path' => null,
                'category_id' => 2,
            ],
            [
                'name' => 'HK417',
                'description' => 'Battle Rifle Semi-Auto chambered in 7.62 NATO. Superior accuracy and stopping power. Gas piston operating system. Effective range: 800+ meters. Professional military-grade firearm.',
                'price' => 65000,
                'stock_quantity' => 10,
                'image_path' => null,
                'category_id' => 2,
            ],
            [
                'name' => 'AR-15 Custom Build',
                'description' => 'Modular tactical rifle with premium components. Caliber: 5.56 NATO. Fully customizable with Picatinny rails. Free-floating barrel for accuracy. Includes adjustable stock and handguard.',
                'price' => 48000,
                'stock_quantity' => 22,
                'image_path' => null,
                'category_id' => 2,
            ],

            // Handguns (Category ID: 3)
            [
                'name' => 'Glock 17 Gen 5',
                'description' => 'Industry-standard 9mm tactical duty pistol. Caliber: 9x19mm Parabellum. Capacity: 17 rounds. Safe Action trigger system. Ambidextrous slide stop and magazine catch. Polymer frame with steel slide.',
                'price' => 28000,
                'stock_quantity' => 25,
                'image_path' => null,
                'category_id' => 3,
            ],
            [
                'name' => 'M1911 .45 ACP',
                'description' => 'Classic .45 caliber semi-automatic pistol. Caliber: .45 ACP. Single-action, recoil-operated. Iconic design with proven stopping power. 7+1 round capacity. Steel frame and slide.',
                'price' => 32000,
                'stock_quantity' => 16,
                'image_path' => null,
                'category_id' => 3,
            ],
            [
                'name' => 'HK USP Compact',
                'description' => 'Polymer tactical handgun with advanced ergonomics. Caliber: 9x19mm. Capacity: 12 rounds. Universal Service Pistol design. Recoil-operated system with polymer frame.',
                'price' => 35000,
                'stock_quantity' => 14,
                'image_path' => null,
                'category_id' => 3,
            ],
            [
                'name' => 'P320 SIG Compact',
                'description' => 'Military-grade 9mm with modular design. Caliber: 9x19mm. Capacity: 15 rounds. Service pistol for armed forces worldwide. Striker-fired mechanism with excellent ergonomics.',
                'price' => 30500,
                'stock_quantity' => 20,
                'image_path' => null,
                'category_id' => 3,
            ],
            [
                'name' => 'CZ 75 SP-01',
                'description' => 'Competition and duty pistol with superior accuracy. Caliber: 9x19mm. Capacity: 18 rounds. Steel frame with short recoil system. Ambidextrous safety and decocker.',
                'price' => 31000,
                'stock_quantity' => 17,
                'image_path' => null,
                'category_id' => 3,
            ],

            // Shotguns (Category ID: 4)
            [
                'name' => 'Remington 870 Tactical',
                'description' => '12-gauge pump shotgun for tactical operations. Capacity: 8 rounds. Picatinny rail for optics. Corrosion-resistant finish. Reliable pump-action mechanism. Perfect for home defense.',
                'price' => 42000,
                'stock_quantity' => 11,
                'image_path' => null,
                'category_id' => 4,
            ],
            [
                'name' => 'Benelli M4 Super90',
                'description' => 'Semi-auto tactical shotgun with inertia recoil system. Caliber: 12-gauge. Capacity: 5+1 rounds. Chrome-lined bore for durability. Used by military and law enforcement worldwide.',
                'price' => 48000,
                'stock_quantity' => 9,
                'image_path' => null,
                'category_id' => 4,
            ],
            [
                'name' => 'Mossberg 500 Combat',
                'description' => 'Combat pump shotgun with reliable dual extractors. Caliber: 12-gauge. Capacity: 8 rounds. Rugged all-weather construction. Heat shield and ghost ring sights included.',
                'price' => 38000,
                'stock_quantity' => 13,
                'image_path' => null,
                'category_id' => 4,
            ],
            [
                'name' => 'Saiga-12 Semi-Auto',
                'description' => 'Bullpup tactical semi-automatic shotgun. Caliber: 12-gauge. Capacity: 5 rounds. Piston-driven operating system. Compact design with generous firepower.',
                'price' => 51000,
                'stock_quantity' => 8,
                'image_path' => null,
                'category_id' => 4,
            ],
            [
                'name' => 'KSG Bullpup',
                'description' => 'Dual-magazine bullpup shotgun with innovative design. Caliber: 12-gauge. Dual magazine system for 14 rounds capacity. Ambidextrous controls. Pump-action reliability.',
                'price' => 45000,
                'stock_quantity' => 10,
                'image_path' => null,
                'category_id' => 4,
            ],

            // Air Guns (Category ID: 5)
            [
                'name' => 'Umarex Walther PPK/S Air Pistol',
                'description' => 'CO2 replica pistol with licensed design. Caliber: .177 (4.5mm BB). Capacity: 12 rounds. Single and double action trigger. Die-cast slide assembly for authenticity.',
                'price' => 12500,
                'stock_quantity' => 30,
                'image_path' => null,
                'category_id' => 5,
            ],
            [
                'name' => 'Gamo Hunter Extreme Pellet Rifle',
                'description' => 'High-powered .177 air rifle with break-barrel design. Power: 1250 FPS. Effective range: 50+ yards. All-weather synthetic stock. Perfect for hunting small game.',
                'price' => 18000,
                'stock_quantity' => 19,
                'image_path' => null,
                'category_id' => 5,
            ],
            [
                'name' => 'Hatsan 125 Air Rifle',
                'description' => 'High-powered pellet rifle with side-lever cocking. Caliber: .177 or .22. Power: 1000+ FPS. Precision rifled barrel. Lightweight for field use.',
                'price' => 22000,
                'stock_quantity' => 14,
                'image_path' => null,
                'category_id' => 5,
            ],
            [
                'name' => 'Daisy Powerline CO2 Rifle',
                'description' => 'Entry-level CO2 air rifle with precision engineering. Caliber: .177 BB or pellet. Velocity: 700 FPS. Lightweight composite stock. Great for beginners.',
                'price' => 15000,
                'stock_quantity' => 23,
                'image_path' => null,
                'category_id' => 5,
            ],
            [
                'name' => 'AirForce Texan LS Air Rifle',
                'description' => 'Premium large-caliber PCP air rifle. Caliber: .457 (11.5mm). Power: 500+ FPE. Professional-grade accuracy and power. Regulated system for consistent performance.',
                'price' => 28000,
                'stock_quantity' => 6,
                'image_path' => null,
                'category_id' => 5,
            ],

            // Antique Firearms (Category ID: 6)
            [
                'name' => 'Mosin-Nagant M1891',
                'description' => 'Russian bolt-action rifle (deactivated). Caliber: 7.62x54mmR. Historically significant WWI-era firearm. Collectible piece of military history. Includes original accessories.',
                'price' => 18000,
                'stock_quantity' => 8,
                'image_path' => null,
                'category_id' => 6,
            ],
            [
                'name' => 'Lee-Enfield No. 4 Mk I',
                'description' => 'British WWI rifle (deactivated). Caliber: .303 British. Rapid bolt-action capability. Historical significance from Great War. Excellent condition with original markings.',
                'price' => 21000,
                'stock_quantity' => 7,
                'image_path' => null,
                'category_id' => 6,
            ],
            [
                'name' => 'Mauser K98 Karabiner',
                'description' => 'German WWII rifle (deactivated). Caliber: 7.92x57mm. Classic bolt-action design. Rare collectible from WWII era. Complete with military markings and serial numbers.',
                'price' => 25000,
                'stock_quantity' => 5,
                'image_path' => null,
                'category_id' => 6,
            ],
            [
                'name' => '1873 Colt Peacemaker',
                'description' => 'Replica antique handgun with authentic design. Caliber: .45 Long Colt. Legendary Old West revolver. Quality reproduction with working firearm.',
                'price' => 22500,
                'stock_quantity' => 9,
                'image_path' => null,
                'category_id' => 6,
            ],
            [
                'name' => 'Spencer Carbine Reproduction',
                'description' => 'American Civil War rifle reproduction. Caliber: .56-50 Spencer. Lever-action repeating rifle. Historical significance from 1860s conflict. Functional reproduction model.',
                'price' => 19500,
                'stock_quantity' => 6,
                'image_path' => null,
                'category_id' => 6,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
