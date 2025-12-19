<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== All Categories ===\n\n";
$categories = App\Models\Category::all();
foreach ($categories as $cat) {
    echo "- {$cat->name} (slug: {$cat->slug}, id: {$cat->id})\n";
}
