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
     * @param bool $printable
     * @return \niklasravnsborg\LaravelPdf\Pdf
     */
    public static function generateRecordBook(Soldier $soldier, $printable = false)
    {
        // Strategic mPDF Configuration for Bangla support
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
            'instanceConfigurator' => function($mpdf) use ($logoPath, $printable) {
                if (file_exists($logoPath)) {
                    $mpdf->SetWatermarkImage($logoPath, 0.05, 'F');
                    $mpdf->showWatermarkImage = true;
                }
                
                if ($printable) {
                    $mpdf->SetJS('this.print();');
                }
            }
        ];

        return Pdf::loadView('admin.soldiers.record-book-pdf', compact('soldier'), [], $options);
    }

    /**
     * Generate bulk Record Books PDF for multiple soldiers.
     *
     * @param \Illuminate\Database\Eloquent\Collection $soldiers
     * @param bool $printable
     * @return \niklasravnsborg\LaravelPdf\Pdf
     */
    public static function generateBulkRecordBooks($soldiers, $printable = false)
    {
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
            'instanceConfigurator' => function($mpdf) use ($logoPath, $printable) {
                if (file_exists($logoPath)) {
                    $mpdf->SetWatermarkImage($logoPath, 0.05, 'F');
                    $mpdf->showWatermarkImage = true;
                }
                
                if ($printable) {
                    $mpdf->SetJS('this.print();');
                }
            }
        ];

        // Increase limits for intense bulk PDF generation
        ini_set('pcre.backtrack_limit', '10000000');
        ini_set('pcre.recursion_limit', '2000000');
        ini_set('memory_limit', '512M');

        return Pdf::loadView('admin.soldiers.bulk-record-books-pdf', compact('soldiers'), [], $options);
    }
}
