<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;

echo "=== CATEGORIES ===\n\n";

$categories = Category::all(['id', 'name']);

foreach($categories as $c) {
    echo "[{$c->id}] {$c->name}\n";
}
