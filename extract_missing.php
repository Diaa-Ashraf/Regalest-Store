<?php

$dir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$keys = [];

foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }
    $content = file_get_contents($file->getRealPath());

    // Matches __('...'), @lang('...'), trans('...')
    if (preg_match_all("/(?:__|@lang|trans)\s*\(\s*(['\"])(.*?)\\1\s*[\),]/u", $content, $matches)) {
        foreach ($matches[2] as $k) {
            $k = trim($k);
            if ($k !== '' && !str_starts_with($k, 'layouts.') && !str_starts_with($k, 'pagination.') && !str_starts_with($k, 'validation.')) {
                $keys[$k] = $keys[$k] ?? [];
                $keys[$k][] = str_replace(__DIR__ . DIRECTORY_SEPARATOR, '', $file->getRealPath());
            }
        }
    }
}

$existingEn = json_decode(file_get_contents(__DIR__ . '/resources/lang/en.json'), true) ?: [];
$missingKeys = [];
foreach ($keys as $key => $locations) {
    if (!isset($existingEn[$key])) {
        $missingKeys[$key] = array_unique($locations);
    }
}

echo "Total unique translation keys in blade views: " . count($keys) . PHP_EOL;
echo "Existing keys in en.json: " . count($existingEn) . PHP_EOL;
echo "Missing keys count: " . count($missingKeys) . PHP_EOL;

file_put_contents(__DIR__ . '/missing_keys.json', json_encode($missingKeys, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
