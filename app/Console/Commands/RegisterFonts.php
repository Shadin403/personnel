<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Dompdf\Dompdf;
use Dompdf\Options;

class RegisterFonts extends Command
{
    protected $signature = 'fonts:register';
    protected $description = 'Register custom fonts for DomPDF';

    public function handle()
    {
        $this->info("Starting font registration...");

        $options = new Options();
        $options->set('fontDir', storage_path('fonts'));
        $options->set('fontCache', storage_path('fonts'));
        $options->set('isRemoteEnabled', true);
        $options->set('isFontSubsettingEnabled', true);

        $dompdf = new Dompdf($options);
        $fontMetrics = $dompdf->getFontMetrics();

        $fonts = [
            'HindSiliguri' => [
                'normal' => storage_path('fonts/HindSiliguri-Regular.ttf'),
                'bold' => storage_path('fonts/HindSiliguri-Bold.ttf'),
            ]
        ];

        foreach ($fonts as $family => $variants) {
            foreach ($variants as $style => $path) {
                if (file_exists($path)) {
                    $this->info("Registering $family ($style) from $path...");
                    $fontMetrics->registerFont([
                        'family' => $family,
                        'style' => $style,
                        'weight' => ($style === 'bold' ? 'bold' : 'normal'),
                    ], $path);
                } else {
                    $this->error("Font file not found: $path");
                }
            }
        }

        $this->info("Font registration complete. Check storage/fonts for installed-fonts.json");
    }
}
