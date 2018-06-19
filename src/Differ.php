<?php
namespace Differ;

use Funct;
use Symfony\Component\Yaml\Yaml;

function genDiff($file1, $file2, $format)
{
    // if (!class_exists("Funct", false)) {
    //     require(__DIR__ . '/../vendor/funct/funct/src/General.php');
    // }

    if ($format == "json" || $format == "pretty") {
        $func = function ($fileData) {
            return json_decode($fileData);
        };
        fileDiff($file1, $file2, $func);
    }

    if ($format == "yaml") {
        $func = function ($fileData) {
            return Yaml::parse($fileData);
        };
        fileDiff($file1, $file2, $func);
    }
}

function fileDiff($file1, $file2, $func)
{
    function objToArray($file, $func)
    {
        $result = [];
        $fileData = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $file);
        $data = $func($fileData);

        foreach ($data as $key => $value) {
            $result[$key] = $value;
        }
            return $result;
    }

    $before = objToArray($file1, $func);
    $after = objToArray($file2, $func);

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
