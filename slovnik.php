<?php
ini_set('max_execution_time', 0);
mb_internal_encoding('UTF-8');

$zip = new ZipArchive;
$res = $zip->open('czech-dictionaries.oxt');
if ($res === TRUE) {
    $zip->extractTo('slovnik/');
    $zip->close();
    echo "rozbaleno<br>\n";
} else {
    echo "zip nenalezen<br>\n";
}

$lines = file("slovnik/cs_CZ.dic");
$dic = "slova";

if (!file_exists($dic)) {
    mkdir($dic, 0777, true);
}

$pod = true;
$prid = true;
$pris = true;
$slov = true;
for ($i = 0; $i < count($lines); $i++) {
    $currentLine = explode("/", $lines[$i]);
    if (isset($currentLine[1])) {
        if ((strpbrk($currentLine[1], "HZ") != false)) {
            if ($pod) {
                file_put_contents($dic . "/podstatny.boubik", mb_convert_encoding(preg_replace('/\s+/', '', $currentLine[0]), "UTF-8", "ISO-8859-2"), FILE_APPEND);
                $pod = false;
            } else {
                file_put_contents($dic . "/podstatny.boubik", ";" . mb_convert_encoding(preg_replace('/\s+/', '', $currentLine[0]), "UTF-8", "ISO-8859-2"), FILE_APPEND);
            }
        }
        if (substr($currentLine[1], 0, 2) == "YK") {
            if ($prid) {
                file_put_contents($dic . "/pridavny.boubik", mb_convert_encoding(preg_replace('/\s+/', '', $currentLine[0]), "UTF-8", "ISO-8859-2"), FILE_APPEND);
                $prid = false;
            } else {
                file_put_contents($dic . "/pridavny.boubik", ";" . mb_convert_encoding(preg_replace('/\s+/', '', $currentLine[0]), "UTF-8", "ISO-8859-2"), FILE_APPEND);
            }
        }
        if (substr($currentLine[1], 0, 2) == "MQ") {
            if ($pris) {
                file_put_contents($dic . "/prislovce.boubik", mb_convert_encoding(preg_replace('/\s+/', '', $currentLine[0]), "UTF-8", "ISO-8859-2"), FILE_APPEND);
                $pris = false;
            } else {
                file_put_contents($dic . "/prislovce.boubik", ";" . mb_convert_encoding(preg_replace('/\s+/', '', $currentLine[0]), "UTF-8", "ISO-8859-2"), FILE_APPEND);
            }
        }
        if (substr($currentLine[1], 0, 2) == "IN") {
            if ($slov) {
                file_put_contents($dic . "/slovesa.boubik", mb_convert_encoding(preg_replace('/\s+/', '', $currentLine[0]), "UTF-8", "ISO-8859-2"), FILE_APPEND);
                $slov = false;
            } else {
                file_put_contents($dic . "/slovesa.boubik", ";" . mb_convert_encoding(preg_replace('/\s+/', '', $currentLine[0]), "UTF-8", "ISO-8859-2"), FILE_APPEND);
            }
        }
    }
}
require "functions.php";
deleteDir("slovnik");
echo "done";

if ($_GET["return"]) {
    header("Location: index.php");
}
