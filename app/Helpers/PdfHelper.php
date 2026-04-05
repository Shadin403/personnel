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
    public static function generateBulkRecordBooks($soldiers, $printable = false, $ipft_fails = null, $ret_fails = null, $overweight_fails = null)
    {
        ini_set('pcre.backtrack_limit', '5000000');
        ini_set('memory_limit', '512M');
        set_time_limit(300);

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

        return Pdf::loadView('admin.soldiers.bulk-record-books-pdf', compact('soldiers', 'ipft_fails', 'ret_fails', 'overweight_fails'), [], $options);
    }

    public static function generateRegistryPdf($ipft_fails, $ret_fails, $overweight_fails, $printable = false)
    {
        ini_set('pcre.backtrack_limit', '5000000');
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $logoPath = public_path('assets/logos/SAJHSF.png');

        $options = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'nikosh',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 15,
            'display_mode' => 'fullpage',
            'instanceConfigurator' => function($mpdf) use ($logoPath, $printable) {
                if ($printable) {
                    $mpdf->SetJS('this.print();');
                }
                $mpdf->SetHeader('Improvement Registry Nominal Roll|UNCLASSIFIED|{DATE d M Y}');
                $mpdf->SetFooter('9 E BENGAL|UNCLASSIFIED|Page {PAGENO}');
            }
        ];

        return Pdf::loadView('admin.soldiers.improvement-registry-pdf', compact('ipft_fails', 'ret_fails', 'overweight_fails'), [], $options);
    }
}
