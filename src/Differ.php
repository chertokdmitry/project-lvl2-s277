<?php
namespace Differ;

use Funct;

function genDiff($jsonFile1, $jsonFile2)
{
    if (!class_exists("Funct", false)) {
        require(__DIR__ . '/../vendor/funct/funct/src/General.php');
    }

    function jsonToArray($file)
    {
        $result = [];
        $jsonData = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $file);
        $data = json_decode($jsonData);
        foreach ($data as $key => $value) {
            $result[$key] = $value;
        }
            return $result;
    }
        
    $before = jsonToArray($jsonFile1);
    $after = jsonToArray($jsonFile2);

    echo "{"  . "\n";
    foreach ($after as $key => $value) {
        if (!Funct\arrayKeyNotExists($key, $before)) {
            if ($before[$key] == $after[$key]) {
                    echo "  " . $key . " : " . $before[$key] . "\n";
            } else {
                 echo "+ " . $key . " : " . $before[$key] . "\n";

                echo "- " . $key . " : " . $after[$key] . "\n";
            }
        } else {
            echo "+ " . $key . " : " . $value . "\n";
        }
    }
    foreach ($before as $key => $value) {
        if (Funct\arrayKeyNotExists($key, $after)) {
            echo "- " . $key . " : " . $before[$key] . "\n";
        }
    }
            echo "}"  . "\n";
}
