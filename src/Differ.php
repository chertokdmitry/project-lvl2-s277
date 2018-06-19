<?php
namespace Differ;

use Funct;

class DiffJson
{
    public function genDiff($jsonFile1, $jsonFile2)
    {
        $beforeJsonData = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $jsonFile1);
        $beforeData = json_decode($beforeJsonData);
        $before = [];

        foreach ($beforeData as $key1 => $value1) {
            $before[$key1] = $value1;
        }

        $afterJsonData = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $jsonFile2);
        $afterData = json_decode($afterJsonData);
        $after = [];

        foreach ($afterData as $key => $value) {
            $after[$key] = $value;
        }
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
}
