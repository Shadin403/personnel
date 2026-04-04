<?php

return [
    'mode'                  => 'utf-8',
    'format'                => 'A4',
    'author'                => 'Soldier Management System',
    'subject'               => 'Personnel Record',
    'keywords'              => 'Bengali, Military, Record',
    'creator'               => 'Laravel Pdf',
    'display_mode'          => 'fullpage',
    'tempDir'               => storage_path('app/pdf/temp'),
    'pdf_a'                 => false,
    'pdf_a_auto_substitution' => false,
    'icc_profile_path'      => '',
    'font_path'             => storage_path('fonts/'),
    'font_data' => [
        'hindsiliguri' => [
            'R'  => 'HindSiliguri-Regular.ttf',
            'B'  => 'HindSiliguri-Bold.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
        'nikosh' => [
            'R'  => 'HindSiliguri-Regular.ttf',
            'B'  => 'HindSiliguri-Bold.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ]
    ]
];
