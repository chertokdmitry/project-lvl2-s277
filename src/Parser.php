<?php
namespace Parser;

use Symfony\Component\Yaml\Yaml;

function parser($file, $format)
{
    $result = [];
    
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

    $data = $func($file);

    foreach ($data as $key => $value) {
            $result[$key] = $value;
    }

    return $result;
}
