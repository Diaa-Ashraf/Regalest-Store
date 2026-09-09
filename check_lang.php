<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

app()->setLocale('en');

echo "Current locale: " . app()->getLocale() . PHP_EOL;
echo "Categories: " . __('Categories') . PHP_EOL;
echo "لوحة الإدارة الفاخرة: " . __('لوحة الإدارة الفاخرة') . PHP_EOL;
echo "إجمالي المبيعات: " . __('إجمالي المبيعات') . PHP_EOL;
echo "Search...: " . __('Search...') . PHP_EOL;

$enJson = json_decode(file_get_contents(resource_path('lang/en.json')), true);
echo "en.json count: " . count($enJson) . PHP_EOL;
echo "has key in json: " . (isset($enJson['لوحة الإدارة الفاخرة']) ? 'YES' : 'NO') . PHP_EOL;
