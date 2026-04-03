<?php
$regPath = 'd:\\laragon\\www\\vue-app-1\\soldier-management\\storage\\fonts\\HindSiliguri-Regular.ttf';
$boldPath = 'd:\\laragon\\www\\vue-app-1\\soldier-management\\storage\\fonts\\HindSiliguri-Bold.ttf';

if (!file_exists($regPath) || !file_exists($boldPath)) {
    die("Font files missing at $regPath or $boldPath");
}

$reg = base64_encode(file_get_contents($regPath));
$bold = base64_encode(file_get_contents($boldPath));

$css = "@font-face {
    font-family: 'HindSiliguri';
    src: url('data:font/ttf;base64,$reg') format('truetype');
    font-weight: normal;
    font-style: normal;
}
@font-face {
    font-family: 'HindSiliguri';
    src: url('data:font/ttf;base64,$bold') format('truetype');
    font-weight: bold;
    font-style: normal;
}";

file_put_contents('d:\\laragon\\www\\vue-app-1\\soldier-management\\tmp\\fonts_css.txt', $css);
echo "Successfully generated fonts_css.txt\n";
