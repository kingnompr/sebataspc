<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

use App\Models\Product;

echo "=== Updating Product Images ===\n\n";

// Mapping nama produk ke file gambar
$imageMapping = [
    // Processors
    'AMD Ryzen 3 3200G' => 'AMD Ryzen 3 3200G-prosesor.png',
    'AMD Ryzen 5 3600' => 'AMD Ryzen 5 3600-prosesor.jpg',
    'AMD Ryzen 5 5600' => 'AMD Ryzen 5 5600-prosesor.jpg',
    'AMD Ryzen 5 5600G' => 'AMD Ryzen 5 5600G-prosesor.jpg',
    'AMD Ryzen 5 7600X' => 'AMD Ryzen 5 7600X-prosesor.jpg',
    'AMD Ryzen 7 5700X' => 'AMD Ryzen 7 5700X-prosesor.png',
    'AMD Ryzen 9 5900X' => 'AMD Ryzen 9 5900X-prosesor.jpg',
    'Intel Core i3-10105' => 'Intel Core i3-10105-prosesor.png',
    'Intel Core i3-12100' => 'Intel Core i3-12100-prosesor.jpg',
    'Intel Core i5-10400F' => 'Intel Core i5-10400F-prosesor.jpg',
    'Intel Core i5-12400F' => 'Intel Core i5-12400F-prosesor.jpg',
    'Intel Core i5-12600KF' => 'Intel Core i5-12600KF-prosesor.jpg',
    'Intel Core i5-13600K' => 'Intel Core i5-13600K-prosesor.jpg',
    'Intel Core i7-12700' => 'Intel Core i7-12700-prosesor.jpg',
    'Intel Core i7-13700K' => 'Intel Core i7-13700K-prosesor.jpg',
    
    // Graphics Cards
    'GTX 1650' => 'GTX-1650-card.png',
    'GTX 1660 Super' => 'gtx-1660-card.jpg',
    'RTX 3060' => 'rtx-3060-card.png',
    'RTX 3070' => 'rtx-3070-card.png',
    'RTX 4060' => 'rtx-4060-card.png',
    'RTX 4070 Twin Edge' => 'RTX4070-TWIN-EDGE-card.jpg',
    'RX 6500 XT' => 'RX-6500-card.jpg',
    'RX 6600' => 'rx-6600-card.png',
    'RX 6700 XT' => 'RX-6700-card.jpg',
    'RX 6800' => 'rx-6800-card.jpg',
    
    // Motherboards
    'ASRock B450 Pro4' => 'ASRock-B450-Pro4-board.png',
    'ASRock B760 Steel Legend' => 'ASRock-B760-Steel-Legend-board.png',
    'ASUS PRIME B660M-A D4' => 'ASUS-PRIME-B660M-A-D4-board.png',
    'ASUS TUF Gaming B550-Plus' => 'ASUS-TUF-Gaming-B550-Plus-board.png',
    'ASUS TUF Gaming B560M-Plus' => 'ASUS-TUF-Gaming-B560M-Plus-board.png',
    'Gigabyte B450M DS3H' => 'Gigabyte-B450M-DS3H-board.png',
    'Gigabyte B760M Aorus Elite AX' => 'Gigabyte-B760M-Aorus-Elite-AX-board.png',
    'MSI B550M Pro-VDH' => 'MSI-B550M-Pro-VDH-board.png',
    'MSI B560M Pro-VDH' => 'MSI-B560M-Pro-VDH-board.jpg',
    'MSI MAG B650 Tomahawk WiFi' => 'MSI-MAG-B650-Tomahawk-WiFi-board.png',
    'MSI PRO B660M-A DDR4' => 'MSI-PRO-B660M-A-DDR4-board.png',
    
    // Memory (RAM)
    'Corsair Vengeance RGB DDR4 3200MHz 16GB' => 'corsair-3200-memory.jpg',
    'Corsair Vengeance RGB DDR4 3600MHz 16GB' => 'corsair-3600-16gb-memory.jpg',
    'Corsair Vengeance RGB DDR4 3600MHz 32GB' => 'corsair-3600-memory.jpg',
    'Corsair Vengeance DDR5 5600MHz 32GB' => 'corsair-5600-memory.jpg',
    'Corsair Vengeance DDR5 6000MHz 32GB' => 'corsair-6000-memory.jpg',
    'Crucial DDR4 3200MHz 16GB' => 'crucial-3200-memory.jpg',
    'G.Skill Ripjaws V DDR4 3200MHz 16GB' => 'g.skill-3200-memory.jpg',
    'G.Skill Ripjaws V DDR4 3600MHz 32GB' => 'g.skill-3600-memory.png',
    'G.Skill Ripjaws S5 DDR5 5600MHz 32GB' => 'g.skill-5600-memory.png',
    'Kingston Fury Beast DDR4 3200MHz 16GB' => 'kingston-3200-memory.jpg',
    'Kingston Fury Beast DDR5 5200MHz 32GB' => 'kingston-5200-memory.jpg',
    'Team Elite DDR4 2666MHz 8GB' => 'teamelite-2666-memory.jpg',
    'TeamGroup T-Force Vulcan Z DDR4 3200MHz 16GB' => 'teamgroup-3200-memory.jpg',
    
    // Storage
    'ADATA XPG SX8200 Pro 1TB' => 'ADATA XPG SX8200 Pro 1TB-storage.jpg',
    'Crucial MX500 1TB' => 'Crucial MX500 1TB-storage.jpg',
    'Kingston A400 480GB' => 'Kingston A400 480GB-storage.jpg',
    'Kingston NV2 1TB NVMe' => 'Kingston NV2 1TB NVMe-storage.jpg',
    'Kingston NV2 500GB NVMe' => 'Kingston NV2 500GB NVMe-storage.jpg',
    'Samsung 980 PRO 1TB' => 'Samsung 980 PRO 1TB-storage.jpg',
    'Seagate Barracuda 1TB 7200RPM' => 'Seagate Barracuda 1TB 7200rpm-storage.jpg',
    'WD Black SN770 1TB' => 'WD Black SN770 1TB-storage.jpg',
    'WD Blue 2TB 5400RPM' => 'WD Blue 2TB 5400rpm-storage.png',
    
    // Power Supply
    'Cooler Master MWE 550 Bronze V2' => 'Cooler-Master-MWE-550-Bronze-V2-psu.jpg',
    'Cooler Master MWE Gold 650W' => 'Cooler-Master-MWE-Gold-650-psu.jpg',
    'Corsair CV550 550W' => 'Corsair-CV550-550W-80Plus-Bronze-psu.jpg',
    'Corsair RM750x 750W' => 'Corsair-RM750x-80Plus-Gold-psu.jpg',
    'Corsair TX650M 650W' => 'Corsair-TX650M-650W-80Plus-Gold-Semi-Modular-psu.jpg',
    'EVGA SuperNOVA 750 G5' => 'EVGA-SuperNOVA-750-G5-750W-80Plus-Gold-psu.png',
    'Seasonic Focus GX-850' => 'Seasonic-Focus-GX-850-850W-80Plus-Gold-psu.png',
    'Seasonic S12III 650W' => 'Seasonic-S12III-650W-80Plus-Bronze-psu.jpg',
    
    // Casing
    'Armaggeddon Kagami K1' => 'armaggeddon.jpg',
    'Cooler Master MasterBox Q300L' => 'cooler-master.jpg',
    'Cube Gaming Gymir' => 'cube-gaming.jpg',
    'Lian Li Lancool 205 Mesh' => 'lianli-lancool-205.jpg',
    'Lian Li Lancool II Mesh' => 'lianli-lancool.jpg',
    'NZXT H510' => 'nzxt-h510.jpg',
    'NZXT H7 Flow' => 'nzxt-h7-flow.jpg',
    'Paradox Gaming Cortex' => 'paradox-gaming-cortex.jpg',
    'Phanteks Eclipse P300A' => 'phanteks-eclipse.jpg',
    'Techware Forge M' => 'techware-forge.jpg',
    'Vortex V3' => 'vortex-casing.jpg',
    
    // CPU Coolers
    'AMD Wraith Stealth' => 'amd-wraith-stealth.jpg',
    'Corsair iCUE H100i' => 'corsair-icue.jpg',
    'DeepCool AK400' => 'deepcool-gammaxx.jpg',
    'DeepCool Castle 240EX' => 'deepcool-castle.jpg',
    'DeepCool LS520' => 'deepcool-ls520.jpg',
    'Intel Stock Cooler' => 'intel-stock-cooler.png',
    'Noctua NH-D15' => 'noctua-nh.jpg',
    'Scythe Mugen 5' => 'scythe-mugen.jpg',
];

$updated = 0;
$notFound = 0;

foreach ($imageMapping as $productName => $imageFile) {
    // Try to find product by name (case insensitive, partial match)
    $product = Product::where('name', 'LIKE', "%$productName%")->first();
    
    if ($product) {
        $product->image = "images/products/$imageFile";
        $product->save();
        echo "✅ Updated: {$product->name} -> $imageFile\n";
        $updated++;
    } else {
        echo "❌ Not found: $productName\n";
        $notFound++;
    }
}

echo "\n=== Summary ===\n";
echo "✅ Updated: $updated products\n";
echo "❌ Not found: $notFound products\n";
echo "\nDone!\n";
