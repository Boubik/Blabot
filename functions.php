<?php

function load_csv($file = "", $slovnik = false)
{
    if ($file == "") {
        $file = "patern.csv";
    }
    $handle = fopen($file, "r");
    $csv = array();
    while (($line = fgets($handle)) !== false) {
        if ($slovnik) {
            $values = explode(";", $line);
            foreach ($values as $value) {
                $csv[] = $value;
            }
        } else {
            $csv[] = explode(";", $line);
        }
    }

    return $csv;
}

function generate_sentence(array $param)
{
    mb_internal_encoding('UTF-8');
    $sentence = "";
    /*foreach ($param as $value) {
        echo $value . " ";
    }
    echo "<br>\n";
    echo "<br>\n";*/

    $fileList = glob('slova/*.boubik');
    $slova = array();
    foreach ($fileList as $file) {
        $name = explode("/", $file);
        $name = explode(".boubik", $name[1]);
        $name = $name[0];
        $slova[$name] = load_csv($file, true);
    }
    /*foreach ($slova as $key => $line) {
        echo $key . ": ";
        print_r($line);
        echo "<br>\n";
    }
    echo "<br>\n";*/

    foreach ($param as $key => $value) {
        $value = preg_replace('/\s+/', '', $value);
        if (mb_substr($value, 0, 1) == "(") {
            if (rand(0, 100) <= 70) {
                $value = mb_substr(mb_substr($value, 1), 0, mb_strlen($value) - 2);
            } else {
                continue;
            }
        }
        $memory = $slova[$value];
        if ($key == 0) {
            $sentence .= $memory[rand(0, count($memory) - 1)];
        } else {
            $sentence .= " " . $memory[rand(0, count($memory) - 1)];
        }
    }

    return $sentence . ".";
}