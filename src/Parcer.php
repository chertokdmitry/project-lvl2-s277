<?php
namespace Parcer;

use Symfony\Component\Yaml\Yaml;

function parcer($file1, $file2, $format)
{
    if ($format == "json" || $format == "pretty") {
        $func = function ($fileData) {
            return json_decode($fileData);
        };
    }

    if ($format == "yaml") {
        $func = function ($fileData) {
            return Yaml::parse($fileData);
        };
    }

    $before = objToArray($file1, $func);
    $after = objToArray($file2, $func);

    return [$before, $after];
}

function objToArray($file, $func)
{
    $result = [];
    $fileData = file_get_contents(__DIR__ .'/../data/' . $file);
    $data = $func($fileData);

    foreach ($data as $key => $value) {
            $result[$key] = $value;
    }

    return $result;
}
