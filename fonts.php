<?php

use NormanHuth\Helpers\Str;

require __DIR__ . '/vendor/autoload.php';

$directories = glob(__DIR__ . '/../src/renderer/public/fonts/*', GLOB_ONLYDIR);

$contents = $fontsJS = '';
$saveList = "module.exports = [\n  'font-sans',\n  'font-serif',\n  'font-mono',";
$fontList['font-sans'] = 'UI Sans Serif';
$fontList['font-serif'] = 'UI Serif';
$fontList['font-mono'] = 'UI Monospace';

foreach ($directories as $directory) {
    $font = basename($directory);
    $slug = Str::slug($font);
    if (!file_exists(__DIR__ . '/../src/renderer/src/assets/scss/fonts/' . $slug . '.scss')) {
        echo 'Font-Face for ' . $font . 'not found!';
        continue;
    }
    if ($contents) {
        $contents .= ",\n";
    }

    $contents .= '\'fonts/' . $slug . '\'';

    if ($fontsJS) {
        $fontsJS .= ",\n";
        $saveList .= ',';
    }

    $saveList .= "\n  'font-" . $slug . '\'';

    $fontList['font-' . $slug] = $font;

    $key = str_contains($slug, '-') ? '\'' . $slug . '\'' : $slug;
    $fontsJS .= '  ' . $key . ': [\'' . $font . '\']';
}

$saveList .= '';

file_put_contents(
    __DIR__ . '/../src/renderer/src/assets/scss/_fonts.scss',
    '@import ' . $contents . ';'
);

file_put_contents(
    __DIR__ . '/../src/renderer/resources/fonts.js',
    "export default {\n" . $fontsJS . "\n}"
);
file_put_contents(
    __DIR__ . '/../src/renderer/data/fonts.json',
    jsonPrettyEncode($fontList)
);

file_put_contents(
    __DIR__ . '/../src/renderer/resources/used/font-family.js',
    $saveList . "\n]\n"
);
