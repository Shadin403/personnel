<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\CanvasFactory;
use Dompdf\FontMetrics;
use Dompdf\Options;

$fontsPath = __DIR__ . '/../storage/fonts/';

$options = new Options();
$options->set('fontDir', $fontsPath);
$options->set('fontCache', $fontsPath);
$options->set('isRemoteEnabled', true);
$options->set('isFontSubsettingEnabled', true);

$dompdf = new Dompdf($options);
$fontMetrics = $dompdf->getFontMetrics();

$fonts = [
    'HindSiliguri' => [
        'normal' => $fontsPath . 'HindSiliguri-Regular.ttf',
        'bold' => $fontsPath . 'HindSiliguri-Bold.ttf',
    ]
];

foreach ($fonts as $family => $variants) {
    foreach ($variants as $style => $path) {
        if (file_exists($path)) {
            echo "Registering $family ($style) from $path...\n";
            $fontMetrics->registerFont([
                'family' => $family,
                'style' => $style,
                'weight' => ($style === 'bold' ? 'bold' : 'normal'),
            ], $path);
        } else {
            echo "Font file not found: $path\n";
        }
    }
}

echo "Font registration complete. Check storage/fonts for .php files.\n";
