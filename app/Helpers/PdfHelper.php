<?php

namespace App\Helpers;

use niklasravnsborg\LaravelPdf\Facades\Pdf;
use App\Models\Soldier;

class PdfHelper
{
    /**
     * Generate a Record Book PDF for a soldier.
     *
     * @param Soldier $soldier
     * @return \Barryvdh\DomPDF\PDF|\niklasravnsborg\LaravelPdf\Pdf
     */
    public static function generateRecordBook(Soldier $soldier)
    {
        // Strategic mPDF Configuration for Bangla support
        // Secure watermark path and configuration
        $logoPath = public_path('assets/logos/SAJHSF.png');

        $options = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'nikosh',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'display_mode' => 'fullpage',
            'instanceConfigurator' => function($mpdf) use ($logoPath) {
                if (file_exists($logoPath)) {
                    $mpdf->SetWatermarkImage($logoPath, 0.05, 'F');
                    $mpdf->showWatermarkImage = true;
                }
            }
        ];

        return Pdf::loadView('admin.soldiers.record-book-pdf', compact('soldier'), [], $options);
    }
}
