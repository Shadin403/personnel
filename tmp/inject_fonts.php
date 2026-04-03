<?php
$pdfTemplatePath = 'd:\\laragon\\www\\vue-app-1\\soldier-management\\resources\\views\\admin\\soldiers\\record-book-pdf.blade.php';
$fontsCssPath = 'd:\\laragon\\www\\vue-app-1\\soldier-management\\tmp\\fonts_css.txt';

if (!file_exists($pdfTemplatePath) || !file_exists($fontsCssPath)) {
    die("Data missing");
}

$template = file_get_contents($pdfTemplatePath);
$fontsCss = file_get_contents($fontsCssPath);

// Regex to replace the @font-face blocks
$pattern = '/@font-face\s*\{[^}]*\}\s*@font-face\s*\{[^}]*\}/s';
$newTemplate = preg_replace($pattern, $fontsCss, $template, 1);

if ($newTemplate === null) {
    die("Regex failed");
}

file_put_contents($pdfTemplatePath, $newTemplate);
echo "Successfully updated record-book-pdf.blade.php with Base64 fonts\n";
