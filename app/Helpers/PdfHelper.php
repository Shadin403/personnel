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
        $options = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'nikosh',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 10,
            'margin_bottom' => 10,
            'display_mode' => 'fullpage',
        ];

        return Pdf::loadView('admin.soldiers.record-book-pdf', compact('soldier'), [], $options);
    }
}
